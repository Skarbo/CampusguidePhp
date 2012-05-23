<?php

class GroupTypeElementBuildingDbDao extends GroupTypeElementBuildingDao
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

        $model = GroupTypeElementBuildingFactoryModel::createGroupTypeElementBuilding(
                Core::arrayAt( $modelArray, Resource::db()->groupTypeElementBuilding()->getFieldName() ) );

        $model->setId(
                intval( Core::arrayAt( $modelArray, Resource::db()->groupTypeElementBuilding()->getFieldId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->groupTypeElementBuilding()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->groupTypeElementBuilding()->getFieldRegistered() ) ) );

        return $model;

    }

    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->groupTypeElementBuilding()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->groupTypeElementBuilding()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return null;
    }

    /**
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = GroupTypeElementBuildingModel::get_( $model );
        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->groupTypeElementBuilding()->getFieldName() ] = ":name";
        $binds[ "name" ] = $model->getName();

        if ( !$isInsert )
        {
            $fields[ Resource::db()->groupTypeElementBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new GroupTypeElementBuildingListModel();
    }

    // /FUNCTIONS


}

?>