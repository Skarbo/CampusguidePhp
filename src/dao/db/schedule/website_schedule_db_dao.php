<?php

class WebsiteScheduleDbDao extends StandardDbDao implements WebsiteScheduleDao
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
        return Resource::db()->websiteSchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->websiteSchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->websiteSchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = WebsiteScheduleModel::get_( $model );

        if ( !is_null( $model->getUrl() ) )
        {
            $fields[ Resource::db()->websiteSchedule()->getFieldUrl() ] = ":url";
            $binds[ "url" ] = $model->getUrl();
        }
        if ( !is_null( $model->getType() ) )
        {
            $fields[ Resource::db()->websiteSchedule()->getFieldType() ] = ":type";
            $binds[ "type" ] = $model->getType();
        }

        if ( !$isInsert )
        {
            $fields[ Resource::db()->websiteSchedule()->getFieldParsed() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new WebsiteScheduleListModel();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = WebsiteScheduleFactoryModel::createWebsiteSchedule(
                Core::arrayAt( $modelArray, Resource::db()->websiteSchedule()->getFieldUrl() ),
                Core::arrayAt( $modelArray, Resource::db()->websiteSchedule()->getFieldType() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setParsed(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->websiteSchedule()->getFieldParsed() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->websiteSchedule()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    /**
     * @see WebsiteScheduleDao::addBuilding()
     * @throws DbException
     */
    public function addBuilding( $websiteId, $buildingId )
    {
        $insertQuery = new InsertQueryDbCore();

        $insertBuilder = new InsertSqlbuilderDbCore();
        $insertBuilder->setInto( Resource::db()->websiteSchedule()->getTableBuilding() );
        $insertBuilder->setSetValues(
                array ( Resource::db()->websiteSchedule()->getFieldBuildingWebsiteId() => ":websiteId",
                        Resource::db()->websiteSchedule()->getFieldBuildingBuildingId() => ":buildingId" ) );
        $insertQuery->setQuery( $insertBuilder );

        $insertQuery->addBind( array ( "websiteId" => $websiteId, "buildingId" => $buildingId ) );

        $result = $this->getDbApi()->query( $insertQuery );

        return $result->isExecute();
    }

    // /FUNCTIONS


}

?>