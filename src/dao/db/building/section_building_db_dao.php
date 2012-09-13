<?php

class SectionBuildingDbDao extends StandardDbDao implements SectionBuildingDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        // Create SectionBuilding
        $sectionBuilding = SectionBuildingFactoryModel::createSectionBuilding(
                Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldBuildingId() ),
                Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldCoordinates() ) );

        $sectionBuilding->setId(
                intval( Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldId() ) ) );
        $sectionBuilding->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldUpdated() ) ) );
        $sectionBuilding->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->sectionBuilding()->getFieldRegistered() ) ) );

        // Return SectionBuilding
        return $sectionBuilding;

    }

    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->sectionBuilding()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->sectionBuilding()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->sectionBuilding()->getFieldBuildingId();
    }

    /**
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = SectionBuildingModel::get_( $model );

        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->sectionBuilding()->getFieldBuildingId() ] = ":buildingId";
        $binds[ "buildingId" ] = $foreignId;
        $fields[ Resource::db()->sectionBuilding()->getFieldName() ] = ":name";
        $binds[ "name" ] = $model->getName();
        $fields[ Resource::db()->sectionBuilding()->getFieldCoordinates() ] = ":coordinates";
        $binds[ "coordinates" ] = $model->getCoordinates();

        if ( !$isInsert )
        {
            $fields[ Resource::db()->sectionBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new SectionBuildingListModel();
    }

    // /FUNCTIONS


}

?>