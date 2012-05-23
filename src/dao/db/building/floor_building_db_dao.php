<?php

class FloorBuildingDbDao extends FloorBuildingDao
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

        // Create FloorBuilding
        $floorBuilding = FloorBuildingFactoryModel::createFloorBuilding(
                Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldBuildingId() ),
                Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldOrder() ),
                Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldCoordinates() ),
                Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldMain() ) );

        $floorBuilding->setId( intval( Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldId() ) ) );
        $floorBuilding->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldUpdated() ) ) );
        $floorBuilding->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->floorBuilding()->getFieldRegistered() ) ) );

        // Return FloorBuilding
        return $floorBuilding;

    }

    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->floorBuilding()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->floorBuilding()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->floorBuilding()->getFieldBuildingId();
    }

    /**
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = FloorBuildingModel::get_( $model );

        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->floorBuilding()->getFieldBuildingId() ] = ":buildingId";
        $binds[ ":buildingId" ] = $foreignId;
        $fields[ Resource::db()->floorBuilding()->getFieldName() ] = ":name";
        $binds[ ":name" ] = Core::decodeUtf8( $model->getName() );
        $fields[ Resource::db()->floorBuilding()->getFieldOrder() ] = ":order";
        $binds[ ":order" ] = $model->getOrder();
        $fields[ Resource::db()->floorBuilding()->getFieldCoordinates() ] = ":coordinates";
        $binds[ ":coordinates" ] = Resource::generateCoordinatesToString( $model->getCoordinates() );
        $fields[ Resource::db()->floorBuilding()->getFieldMain() ] = ":main";
        $binds[ ":main" ] = $model->getMain();

        if ( !$isInsert )
        {
            $fields[ Resource::db()->floorBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new FloorBuildingListModel();
    }

    // /FUNCTIONS


}

?>