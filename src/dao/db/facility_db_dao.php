<?php

class FacilityDbDao extends StandardDbDao implements FacilityDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    /**
     * @see StandardDao::createModel()
     * @return FacilityModel
     */
    protected function createModel( array $modelArray )
    {

        // Create Facility
        $facility = FacilityFactoryModel::createFacility(
                Core::arrayAt( $modelArray, Resource::db()->facility()->getFieldName() ) );

        $facility->setId( intval( Core::arrayAt( $modelArray, Resource::db()->facility()->getFieldId() ) ) );
        $facility->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->facility()->getFieldUpdated() ) ) );
        $facility->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->facility()->getFieldRegistered() ) ) );

        $facility->setBuildings(
                intval( Core::arrayAt( $modelArray, Resource::db()->facility()->getFieldAliasBuildings(), 0 ) ) );

        // Return Facility
        return $facility;

    }

    // ... /CREATE


    // ... GET


    /**
     * @see StandardDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->facility()->getTable();
    }

    /**
     * @see StandardDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->facility()->getFieldId();
    }

    /**
     * @see StandardDao::getForeignField()
     */
    protected function getForeignField()
    {
        return null;
    }

    /**
     * @param FacilityModel $model
     * @see StandardDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $model = FacilityModel::get_( $model );
        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->facility()->getFieldName() ] = ":name";
        $binds[ "name" ] = Core::decodeUtf8( $model->getName() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->facility()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @return FacilityListModel
     * @see StandardDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new FacilityListModel();
    }

    /**
     * @see StandardDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {

        // FACILITY BUILDINGS QUERY


        $selectFacilityBuildingsQuery = new SelectSqlbuilderDbCore();
        $selectFacilityBuildingsQuery->setExpression(
                SB::count( SB::pun( Resource::db()->building()->getTable(), Resource::db()->building()->getFieldId() ) ) );
        $selectFacilityBuildingsQuery->setFrom( Resource::db()->building()->getTable() );
        $selectFacilityBuildingsQuery->setWhere(
                SB::equ(
                        SB::pun( Resource::db()->building()->getTable(),
                                Resource::db()->building()->getFieldFacilityId() ),
                        SB::pun( Resource::db()->facility()->getTable(), Resource::db()->facility()->getFieldId() ) ) );

        // /FACILITY BUILDINGS QUERY


        // Get select query
        $selectQuery = parent::getSelectQuery();

        // ... Build
        $selectQuery->getQuery()->addExpression(
                SB::ifnull( $selectFacilityBuildingsQuery->build(),
                        Resource::db()->facility()->getFieldAliasBuildings(), 0 ) );

        // Return select query
        return $selectQuery;

    }

    // ... /GET


    // /FUNCTIONS


}

?>