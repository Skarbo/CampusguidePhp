<?php

class EntryScheduleDbDao extends StandardDbDao implements EntryScheduleDao
{

    // VARIABLES


    private static $OCCURENCE_SEPERATOR = ",";

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
        return Resource::db()->entrySchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->entrySchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->entrySchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();
        $model = EntryScheduleModel::get_( $model );

        if ( !is_null( $model->getType() ) )
        {
            $fields[ Resource::db()->entrySchedule()->getFieldType() ] = ":type";
            $binds[ "type" ] = $model->getType();
        }
        $fields[ Resource::db()->entrySchedule()->getFieldWebsiteId() ] = ":websiteId";
        $binds[ "websiteId" ] = $foreignId;
        $fields[ Resource::db()->entrySchedule()->getFieldTimeStart() ] = ":timeStart";
        $binds[ "timeStart" ] = date( self::$SQL_DATE_FORMAT_His, $model->getTimeStart() );
        $fields[ Resource::db()->entrySchedule()->getFieldTimeEnd() ] = ":timeEnd";
        $binds[ "timeEnd" ] = date( self::$SQL_DATE_FORMAT_His, $model->getTimeEnd() );

        if ( !$isInsert )
        {
            $fields[ Resource::db()->entrySchedule()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new EntryScheduleListModel();
    }

    /**
     * @see StandardDbDao::getSelectQuery()
     */
    protected function getSelectQuery()
    {
        $selectQuery = parent::getSelectQuery();

        // Occurence
        $selectOccurenceQuery = new SelectSqlbuilderDbCore();
        $selectOccurenceQuery->setFrom( Resource::db()->entrySchedule()->getTableOccurence() );
        $selectOccurenceQuery->setExpression(
                SB::groupConcat(
                        Core::cc( " ", SB::$DISTINCT,
                                SB::pun( Resource::db()->entrySchedule()->getTableOccurence(),
                                        Resource::db()->entrySchedule()->getFieldOccurenceDate() ), SB::$SEPARATOR,
                                SB::quote( self::$OCCURENCE_SEPERATOR ) ) ) );
        $selectOccurenceQuery->addWhere(
                SB::equ(
                        SB::pun( Resource::db()->entrySchedule()->getTableOccurence(),
                                Resource::db()->entrySchedule()->getFieldOccurenceEntryId() ),
                        SB::pun( $this->getTable(), $this->getPrimaryField() ) ) );

        $selectQuery->getQuery()->addExpression( SB::as_( SB::par( $selectOccurenceQuery->build() ) , Resource::db()->entrySchedule()->getFieldAliasOccurence() ) );

        return $selectQuery;
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = EntryScheduleFactoryModel::createEntrySchedule(
                Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldType() ),
                Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldTimeStart() ),
                Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldTimeEnd() ),
                explode( self::$OCCURENCE_SEPERATOR,
                        Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldAliasOccurence() ) ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setWebsiteId( Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldWebsiteId() ) );
        $model->setUpdated( Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldUpdated() ) );
        $model->setRegistered( Core::arrayAt( $modelArray, Resource::db()->entrySchedule()->getFieldRegistered() ) );

        return $model;

    }

    // ... /CREATE


    /**
     * @see EntryScheduleDao::addOccurence()
     * @throws DbException
     */
    public function addOccurence( $entryId, $occurence )
    {
        $insertQuery = new InsertQueryDbCore();

        $insertBuild = new InsertSqlbuilderDbCore();
        $insertBuild->setInto( Resource::db()->entrySchedule()->getTableOccurence() );
        $insertBuild->setSetValues(
                array ( Resource::db()->entrySchedule()->getFieldOccurenceEntryId() => ":entryId",
                        Resource::db()->entrySchedule()->getFieldOccurenceDate() => ":occurence" ) );
        $insertBuild->setDuplicate(
                array ( Resource::db()->entrySchedule()->getFieldOccurenceUpdated() => SB::$CURRENT_TIMESTAMP ) );
        $insertQuery->setQuery( $insertBuild );

        $insertQuery->addBind(
                array ( "entryId" => $entryId, "occurence" => date( self::$SQL_DATE_FORMAT_Ymd, $occurence ) ) );

        $result = $this->getDbApi()->query( $insertQuery );

        return $result->isExecute();
    }

    // /FUNCTIONS


}

?>