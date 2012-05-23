<?php

class TypeElementBuildingDbDao extends TypeElementBuildingDao
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

        // Create TypeElementBuilding
        $typeElementBuilding = TypeElementBuildingFactoryModel::createTypeElementBuilding(
                Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldGroupId() ),
                Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldIcon() ) );

        $typeElementBuilding->setId(
                intval( Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldId() ) ) );
        $typeElementBuilding->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldUpdated() ) ) );
        $typeElementBuilding->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->typeElementBuilding()->getFieldRegistered() ) ) );

        // Return TypeElementBuilding
        return $typeElementBuilding;

    }

    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->typeElementBuilding()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->typeElementBuilding()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->typeElementBuilding()->getFieldGroupId();
    }

    /**
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = TypeElementBuildingModel::get_( $model );
        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->typeElementBuilding()->getFieldName() ] = ":name";
        $binds[ "name" ] = $model->getName();
        $fields[ Resource::db()->typeElementBuilding()->getFieldIcon() ] = ":icon";
        $binds[ "icon" ] = $model->getIcon();

        if ( $model->getGroupId() )
        {
            $fields[ Resource::db()->typeElementBuilding()->getFieldGroupId() ] = ":groupId";
            $binds[ "groupId" ] = $model->getGroupId();
        }
        else
        {
            $fields[ Resource::db()->typeElementBuilding()->getFieldGroupId() ] = SB::$NULL;
        }

        if ( !$isInsert )
        {
            $fields[ Resource::db()->typeElementBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new TypeElementBuildingListModel();
    }

    // /FUNCTIONS


}

?>