<?php

class ElementBuildingDbDao extends StandardDbDao implements ElementBuildingDao
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

        // Create ElementBuilding
        $elementBuilding = ElementBuildingFactoryModel::createElementBuilding(
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldFloorId() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldCoordinates() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldSectionId() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldType() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldTypeGroup() ),
                Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldDeleted() ) );

        $elementBuilding->setId(
                intval( Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldId() ) ) );
        $elementBuilding->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldUpdated() ) ) );
        $elementBuilding->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->elementBuilding()->getFieldRegistered() ) ) );

        // Return ElementBuilding
        return $elementBuilding;

    }

    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->elementBuilding()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->elementBuilding()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->elementBuilding()->getFieldFloorId();
    }

    /**
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = ElementBuildingModel::get_( $model );

        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->elementBuilding()->getFieldFloorId() ] = ":floorId";
        $binds[ "floorId" ] = $foreignId;

        if ( !is_null( $model->getName() ) )
        {
            $fields[ Resource::db()->elementBuilding()->getFieldName() ] = ":name";
            $binds[ "name" ] = $model->getName();
        }

        if ( !is_null( $model->getCoordinates() ) )
        {
            $fields[ Resource::db()->elementBuilding()->getFieldCoordinates() ] = ":coordinates";
            $binds[ "coordinates" ] = Resource::generateCoordinatesToString( $model->getCoordinates() );
        }

        $fields[ Resource::db()->elementBuilding()->getFieldSectionId() ] = $model->getSectionId() ? ":sectionId" : SB::$NULL;
        if ( $model->getSectionId() )
        {
            $binds[ "sectionId" ] = $model->getSectionId();
        }

        if ( !is_null( $model->getType() ) )
        {
            $fields[ Resource::db()->elementBuilding()->getFieldType() ] = ":type";
            $binds[ "type" ] = $model->getType();
        }

        if ( !is_null( $model->getTypeGroup() ) )
        {
            $fields[ Resource::db()->elementBuilding()->getFieldTypeGroup() ] = ":typeGroup";
            $binds[ "typeGroup" ] = $model->getTypeGroup();
        }

        if ( !$isInsert )
        {
            $fields[ Resource::db()->elementBuilding()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new ElementBuildingListModel();
    }

    /**
     * @see ElementBuildingDao::getBuilding()
     */
    public function getBuilding( $buildingId )
    {

        $selectQuery = $this->getSelectQuery();

        $selectQuery->getQuery()->addJoin(
                SB::join( Resource::db()->floorBuilding()->getTable(),
                        SB::equ( SB::pun( $this->getTable(), Resource::db()->elementBuilding()->getFieldFloorId() ),
                                SB::pun( Resource::db()->floorBuilding()->getTable(),
                                        Resource::db()->floorBuilding()->getFieldId() ) ) ) );
        $selectQuery->getQuery()->addWhere(
                SB::equ(
                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                Resource::db()->floorBuilding()->getFieldBuildingId() ), ":building_id" ) );
        $selectQuery->addBind( array ( "building_id" => $buildingId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return $this->createList( $result->getRows() );

    }

    /**
     * @see ElementBuildingDao::delete()
     */
    public function delete( $id )
    {

        // Updated query
        $updatedQuery = new UpdateQueryDbCore(
                new UpdateSqlbuilderDbCore( $this->getTable(),
                        array ( Resource::db()->elementBuilding()->getFieldDeleted() => "1",
                                Resource::db()->elementBuilding()->getFieldUpdated() => SB::$CURRENT_TIMESTAMP ),
                        SB::equ( Resource::db()->elementBuilding()->getFieldId(), ":id" ) ), array ( "id" => $id ) );

        // Query
        $result = $this->getDbApi()->query( $updatedQuery );

        // Return result
        return $result->isExecute();

    }

    /**
     * @see StandardDbDao::getSearchSelectQuery()
     */
    protected function getSearchSelectQuery( $search, $foreignId = null )
    {

        // Select query
        $selectQuery = parent::getSearchSelectQuery( $search, $foreignId );

        // Select build
        $selectBuild = $selectQuery->getQuery();

        // Search expression
        $searchExpression = SB::like( Resource::db()->elementBuilding()->getFieldName(), ":search" );
        $selectBuild->addWhere( $searchExpression );

        if ( $foreignId )
        {
            $selectBuild->addWhere( SB::equ( SB::pun( $this->getTable(), $this->getForeignField() ), ":foreignId" ) );
            $selectQuery->addBind( array ( "foreignId" => $foreignId ) );
        }

        // ... Binds
        $selectQuery->addBind( array ( "search" => $search ) );

        return $selectQuery;

    }

    // /FUNCTIONS


}

?>