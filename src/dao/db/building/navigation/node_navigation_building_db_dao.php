<?php

class NodeNavigationBuildingDbDao extends StandardDbDao implements NodeNavigationBuildingDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see StandardDbDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->nodeNavigationBuilding()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->nodeNavigationBuilding()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->nodeNavigationBuilding()->getFieldFloorId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = NodeNavigationBuildingModel::get_( $model );

        $fields[ Resource::db()->nodeNavigationBuilding()->getFieldFloorId() ] = ":floorId";
        $binds[ "floorId" ] = $foreignId;

        if ( is_numeric( $model->getElementId() ) )
        {
            $fields[ Resource::db()->nodeNavigationBuilding()->getFieldElementId() ] = ":elementId";
            $binds[ "elementId" ] = $model->getElementId();
        }
        else
            $fields[ Resource::db()->nodeNavigationBuilding()->getFieldElementId() ] = SB::$NULL;

        $fields[ Resource::db()->nodeNavigationBuilding()->getFieldCoordinate() ] = ":coordinate";
        $binds[ "coordinate" ] = Resource::generateCoordinatesToString( $model->getCoordinate() );

        if ( !$isInsert )
            $fields[ Resource::db()->nodeNavigationBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new NodeNavigationBuildingListModel();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding(
                Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldFloorId() ),
                Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldCoordinate() ),
                Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldElementId() ),
                Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldAliasEdges() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->nodeNavigationBuilding()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    protected function getSelectQuery()
    {

        $selectQuery = parent::getSelectQuery();

        $edgesSelectQuery = new SelectSqlbuilderDbCore();
        $edgesSelectQuery->setFrom( Resource::db()->edgeNavigationBuilding()->getTable() );
        $edgesSelectQuery->setExpression(
                SB::groupConcat( Resource::db()->edgeNavigationBuilding()->getFieldNodeRight() ) );
        $edgesSelectQuery->setWhere(
                SB::equ( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft(), $this->getPrimaryField() ) );
        $edgesSelectQuery->setGroupBy( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft() );

        $selectQuery->getQuery()->addExpression(
                SB::as_( SB::par( $edgesSelectQuery->build() ),
                        Resource::db()->nodeNavigationBuilding()->getFieldAliasEdges() ) );

        return $selectQuery;

    }

    /**
     * @see NodeNavigationBuildingDao::getBuilding()
     */
    public function getBuilding( $buildingId )
    {

        $selectQuery = $this->getSelectQuery();

        $selectFloorQuery = new SelectSqlbuilderDbCore( Resource::db()->floorBuilding()->getFieldId(),
                Resource::db()->floorBuilding()->getTable(),
                SB::equ( Resource::db()->floorBuilding()->getFieldBuildingId(), ":buildingId" ) );

        $selectQuery->getQuery()->addWhere(
                SB::in( Resource::db()->nodeNavigationBuilding()->getFieldFloorId(), $selectFloorQuery->build() ) );

        $selectQuery->addBind( array ( "buildingId" => $buildingId ) );
        DebugHandler::doDebug( DebugHandler::LEVEL_LOW,
                new DebugException( "NodeNavigationDbDao GetBuilding", $selectQuery->__toString() ) );
        $result = $this->getDbApi()->query( $selectQuery );

        return $this->createList( $result->getRows() );

    }

    /**
     * @see NodeNavigationBuildingDao::getElement()
     */
    public function getElement( $elementId )
    {

        $selectQuery = $this->getSelectQuery();

        $selectQuery->getQuery()->addWhere(
                SB::equ( Resource::db()->nodeNavigationBuilding()->getFieldElementId(), ":elementId" ) );
        $selectQuery->addBind( array ( "elementId" => $elementId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return $result->getSizeRows() > 0 ? $this->createModel( $result->getRows() ) : null;

    }

    public function addEdge( $nodeLeft, $nodeRight )
    {

        if ( $this->hasEdge( $nodeLeft, $nodeRight ) )
            return true;

        $insertQuery = new InsertQueryDbCore();

        $insertBuilder = new InsertSqlbuilderDbCore();
        $insertBuilder->setInto( Resource::db()->edgeNavigationBuilding()->getTable() );
        $insertBuilder->setSetValues(
                array ( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft() => ":nodeLeft",
                        Resource::db()->edgeNavigationBuilding()->getFieldNodeRight() => ":nodeRight" ) );
        $insertBuilder->setDuplicate(
                array ( Resource::db()->edgeNavigationBuilding()->getFieldUpdated() => SB::$CURRENT_TIMESTAMP ) );

        $insertQuery->setQuery( $insertBuilder );
        $insertQuery->addBind( array ( "nodeLeft" => $nodeLeft, "nodeRight" => $nodeRight ) );

        $result = $this->getDbApi()->query( $insertQuery );

        return $result->getAffectedRows() > 0;

    }

    public function hasEdge( $nodeLeft, $nodeRight )
    {

        $selectQuery = new SelectQueryDbCore();

        $selectBuilder = new SelectSqlbuilderDbCore();
        $selectBuilder->setExpression( SB::$TRUE );
        $selectBuilder->setFrom( Resource::db()->edgeNavigationBuilding()->getTable() );
        $selectBuilder->setWhere(
                SB::or_(
                        SB::and_( SB::equ( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft(), ":nodeLeft" ),
                                SB::equ( Resource::db()->edgeNavigationBuilding()->getFieldNodeRight(), ":nodeRight" ) ),
                        SB::and_(
                                SB::equ( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft(), ":nodeRight" ),
                                SB::equ( Resource::db()->edgeNavigationBuilding()->getFieldNodeRight(), ":nodeLeft" ) ) ) );

        $selectQuery->setQuery( $selectBuilder );
        $selectQuery->addBind( array ( "nodeLeft" => $nodeLeft, "nodeRight" => $nodeRight ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return count( $result->getRows() ) > 0;

    }

    /**
     * @see NodeNavigationBuildingDao::removeEdges()
     */
    public function removeEdges( $floorId )
    {

        $deleteQuery = new DeleteQueryDbCore();

        $selectNodeQuery = new SelectSqlbuilderDbCore(
                SB::pun( Resource::db()->nodeNavigationBuilding()->getTable(),
                        Resource::db()->nodeNavigationBuilding()->getFieldId() ),
                Resource::db()->nodeNavigationBuilding()->getTable(),
                SB::equ(
                        SB::pun( Resource::db()->nodeNavigationBuilding()->getTable(),
                                Resource::db()->nodeNavigationBuilding()->getFieldFloorId() ), $floorId ) );

        $deleteBuilder = new DeleteSqlbuilderDbCore();
        $deleteBuilder->setFrom( Resource::db()->edgeNavigationBuilding()->getTable() );
        $deleteBuilder->setWhere(
                SB::or_(
                        SB::in( Resource::db()->edgeNavigationBuilding()->getFieldNodeLeft(),
                                $selectNodeQuery->build() ),
                        SB::in( Resource::db()->edgeNavigationBuilding()->getFieldNodeRight(),
                                $selectNodeQuery->build() ) ) );
        $deleteQuery->setQuery( $deleteBuilder );

        $result = $this->getDbApi()->query( $deleteQuery );

        return $result->getAffectedRows();

    }

    // /FUNCTIONS


}

?>