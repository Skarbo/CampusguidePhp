<?php

class BuildingDbDao extends StandardDbDao implements BuildingDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    /**
     * @see StandardDao::createModel()
     * @return BuildingModel
     */
    protected function createModel( array $modelArray )
    {

        // Create Building
        $building = BuildingFactoryModel::createBuilding(
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldFacilityId() ),
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldAddress() ),
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldPosition() ),
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldLocation() ),
                Core::arrayAt( $modelArray, Resource::db()->building()->getFieldOverlay() ) );

        $building->setId( intval( Core::arrayAt( $modelArray, Resource::db()->building()->getFieldId() ) ) );
        $building->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->building()->getFieldUpdated() ) ) );
        $building->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->building()->getFieldRegistered() ) ) );

        $building->setFloors(
                array_map(
                        function ( $var )
                        {
                            return array_map(
                                    function ( $var )
                                    {
                                        return intval( $var );
                                    }, explode( ",", $var ) );
                        },
                        array_filter(
                                explode( "|",
                                        Core::arrayAt( $modelArray, Resource::db()->building()->getFieldAliasFloors() ) ) ) ) );

        // Return Building
        return $building;

    }

    // ... /CREATE


    // ... GET


    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->building()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->building()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->building()->getFieldFacilityId();
    }

    /**
     * @param BuildingModel $model
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = BuildingModel::get_( $model );
        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->building()->getFieldName() ] = ":name";
        $binds[ "name" ] = Core::utf8Decode( $model->getName() );
        $fields[ Resource::db()->building()->getFieldFacilityId() ] = ":facilityId";
        $binds[ "facilityId" ] = $foreignId;
        $fields[ Resource::db()->building()->getFieldLocation() ] = ":location";
        $binds[ "location" ] = BuildingUtil::generateLocationToString( $model->getLocation() );
        $fields[ Resource::db()->building()->getFieldAddress() ] = ":address";
        $binds[ "address" ] = Core::utf8Decode(
                is_array( $model->getAddress() ) ? implode( "|", $model->getAddress() ) : $model->getAddress() );
        $fields[ Resource::db()->building()->getFieldPosition() ] = ":position";
        $binds[ "position" ] = BuildingUtil::generatePositionToString( $model->getPosition() );
        $fields[ Resource::db()->building()->getFieldOverlay() ] = ":overlay";
        $binds[ "overlay" ] = json_encode( $model->getOverlay() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->building()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @return BuildingListModel
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new BuildingListModel();
    }

    protected function getSelectQuery()
    {

        // BUILDING FLOORS QUERY


        // Create select Building Floors query
        $selectBuildingFloorsQuery = new SelectSqlbuilderDbCore();
        $selectBuildingFloorsQuery->setExpression(
                SB::groupConcat(
                        Core::cc( " ",
                                SB::concat( ",",
                                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                                Resource::db()->floorBuilding()->getFieldId() ),
                                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                                Resource::db()->floorBuilding()->getFieldOrder() ),
                                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                                Resource::db()->floorBuilding()->getFieldMain() ) ), SB::$SEPARATOR,
                                SB::quote( "|" ) ) ) );
        $selectBuildingFloorsQuery->setFrom( Resource::db()->floorBuilding()->getTable() );
        $selectBuildingFloorsQuery->setWhere(
                SB::equ(
                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                Resource::db()->floorBuilding()->getFieldBuildingId() ),
                        SB::pun( Resource::db()->building()->getTable(), Resource::db()->building()->getFieldId() ) ) );

        // BUILDING FLOORS QUERY


        // Get select query
        $selectQuery = parent::getSelectQuery();

        // ... Build
        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::par( $selectBuildingFloorsQuery->build() ),
                        Resource::db()->building()->getFieldAliasFloors() ) );

        return $selectQuery;

    }

    /**
     * @see StandardDao::getSearchSelectQuery()
     */
    protected function getSearchSelectQuery( $search, $foreignId = null )
    {

        // Select query
        $selectQuery = parent::getSearchSelectQuery( $search, $foreignId );

        // Select build
        $selectBuild = $selectQuery->getQuery();

        // Search expression
        $searchExpression = SB::par(
                SB::or_( SB::like( Resource::db()->building()->getFieldName(), ":search" ),
                        SB::like( Resource::db()->building()->getFieldAddress(), ":search" ) ) );

        $selectBuild->addWhere( $searchExpression );
        // ... Binds
        $selectQuery->addBind( array ( "search" => $search ) );

        return $selectQuery;

    }

    // ... /GET


    // /FUNCTIONS


}

?>