<?php

class FloorBuildingDbDao extends StandardDbDao implements FloorBuildingDao
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
     * @see StandardDbDao::getTouchField()
     */
    protected function getTouchField()
    {
        return Resource::db()->floorBuilding()->getFieldUpdated();
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

        if ( !is_null( $model->getName() ) )
        {
            $fields[ Resource::db()->floorBuilding()->getFieldName() ] = ":name";
            $binds[ ":name" ] = Core::decodeUtf8( $model->getName() );
        }
        if ( !is_null( $model->getOrder() ) && !$isInsert )
        {
            $fields[ Resource::db()->floorBuilding()->getFieldOrder() ] = ":order";
            $binds[ ":order" ] = $model->getOrder();
        }
        if ( !is_null( $model->getMain() ) && !$isInsert )
        {
            $fields[ Resource::db()->floorBuilding()->getFieldMain() ] = ":main";
            $binds[ ":main" ] = $model->getMain();
        }

        if ( !Core::isEmpty( $model->getCoordinates() ) )
        {
            $fields[ Resource::db()->floorBuilding()->getFieldCoordinates() ] = ":coordinates";
            $binds[ ":coordinates" ] = $model->getCoordinates();
        }

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

    protected function getSelectQuery()
    {

        $selectQuery = parent::getSelectQuery();

        $selectQuery->getQuery()->setOrderBy(
                array ( array ( Resource::db()->floorBuilding()->getFieldOrder(), SB::$ASC ) ) );

        return $selectQuery;

    }

    /**
     * @see FloorBuildingDao::setMainFloor()
     */
    public function setMainFloor( $buildingId, $id )
    {

        // Update query
        $updateQuery = new UpdateQueryDbCore();

        // ... Builder
        $updateBuilder = new UpdateSqlbuilderDbCore();
        $updateBuilder->setTable( $this->getTable() );
        $updateBuilder->setWhere( SB::equ( $this->getForeignField(), ":buildingId" ) );
        $updateBuilder->setOrderBy( array ( array ( Resource::db()->floorBuilding()->getFieldOrder(), SB::$ASC ) ) );

        if ( $id )
        {
            $updateBuilder->setSet(
                    array (
                            Resource::db()->floorBuilding()->getFieldMain() => SB::if_(
                                    SB::equ( $this->getPrimaryField(), ":floorId" ), 1, 0 ) ) );

            // Binds
            $updateQuery->addBind( array ( "floorId" => $id ) );
        }
        else
        {
            $updateBuilder->setSet( array ( Resource::db()->floorBuilding()->getFieldMain() => 1 ) );
            $updateBuilder->setLimit( 1 );
        }

        // ... Binds
        $updateQuery->addBind( array ( "buildingId" => $buildingId ) );

        $updateQuery->setQuery( $updateBuilder );

        // Query
        $result = $this->getDbApi()->query( $updateQuery );

        // Return executed
        return $result->isExecute();

    }

    // /FUNCTIONS


}

?>