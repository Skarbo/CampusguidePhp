<?php

class LogDbDao extends LogDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    /**
     * @param array $academy
     * @return LogModel
     */
    private static function createLog( array $logArray )
    {
        $log = LogFactoryModel::createLog( Core::arrayAt( $logArray, Resource::db()->log()->getFieldType() ),
                Core::arrayAt( $logArray, Resource::db()->log()->getFieldText() ) );

        $log->setId( intval( Core::arrayAt( $logArray, Resource::db()->log()->getFieldId() ) ) );
        $log->setWebsiteId( intval( Core::arrayAt( $logArray, Resource::db()->log()->getFieldWebsiteId() ) ) );
        $log->setUpdated( Core::trimWhitespace( Core::arrayAt( $logArray, Resource::db()->log()->getFieldUpdated() ) ) );
        $log->setRegistered(
                Core::trimWhitespace( Core::arrayAt( $logArray, Resource::db()->log()->getFieldRegistered() ) ) );

        return $log;
    }

    /**
     * @param array $log_list
     * @return LogListModel
     */
    private static function createLogList( array $logListArray )
    {

        // Initiate objects
        $logList = new LogListModel();

        // Foreach objects
        foreach ( $logListArray as $logArray )
        {
            $logList->add( self::createLog( $logArray ) );
        }

        // Return objects
        return $logList;

    }

    // ... /CREATE


    // ... GET


    /**
     * @return SelectQueryDbCore
     */
    private static function getSelectQuery()
    {

        // Select query
        $select_query = new SelectQueryDbCore();

        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( "*" );
        $select_build->setFrom( Resource::db()->log()->getTable() );

        $select_query->setQuery( $select_build );

        // Return query
        return $select_query;

    }

    // ... /GET


    /**
     * @see ActorDao::get()
     */
    public function get( $logId )
    {

        // Select query
        $select_query = self::getSelectQuery();

        // ... Build
        $select_build = SelectSqlbuilderDbCore::get_( $select_query->getQuery() );
        $select_build->setWhere( SB::equ( Resource::db()->log()->getFieldId(), ":log_id" ) );

        // ... Binds
        $select_query->setBinds( array ( "log_id" => $logId ) );

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return count( $result->getRows() ) > 0 ? $this->createLog( $result->getRow( 0 ) ) : null;

    }

    /**
     * @see LogDao::getList()
     */
    public function getList()
    {

        // Select query
        $select_query = self::getSelectQuery();

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return self::createLogList( $result->getRows() );

    }

    /**
     * @see LogDao::addLog()
     */
    public function add( LogModel $log )
    {
        $setValues = array ();
        $binds = array ();

        $setValues[ Resource::db()->log()->getFieldType() ] = ":type";
        $binds[ "type" ] = $log->getType();
        $setValues[ Resource::db()->log()->getFieldText() ] = ":text";
        $binds[ "text" ] = $log->getText();

        if ( $log->getWebsiteId() )
        {
            $setValues[ Resource::db()->log()->getFieldWebsiteId() ] = ":website";
            $binds[ "website" ] = $log->getWebsiteId();
        }
        if ( $log->getScheduleType() )
        {
            $setValues[ Resource::db()->log()->getFieldScheduleType() ] = ":scheduleType";
            $binds[ "scheduleType" ] = $log->getScheduleType();
        }

        // Insert query
        $insert_query = new InsertQueryDbCore();

        // ... Build
        $insert_build = new InsertSqlbuilderDbCore();
        $insert_build->setInto( Resource::db()->log()->getTable() );
        $insert_build->setSetValues( $setValues );

        $insert_query->setQuery( $insert_build );

        // ... Bind
        $insert_query->setBinds( $binds );

        // Do insert
        $result = $this->getDbApi()->query( $insert_query );

        // Return object id
        return $result->getInsertId();

    }

    /**
     * @see LogDao::removeAll()
     */
    public function removeAll()
    {

        // Delete query
        $delete_query = new DeleteQueryDbCore( new DeleteSqlbuilderDbCore( Resource::db()->log()->getTable() ) );

        // Do delete
        $result = $this->getDbApi()->query( $delete_query );

        // Return number of removed objects
        return $result->getAffectedRows();

    }

    // /FUNCTIONS


}

?>