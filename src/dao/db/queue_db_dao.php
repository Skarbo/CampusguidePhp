<?php

class QueueDbDao extends QueueDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... CREATE


    /**
     * @param array $academy
     * @return QueueModel
     */
    private static function createQueue( array $queueArray )
    {

        // Create Queue
        $queue = QueueFactoryModel::createQueue(
                Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldType() ),
                Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldPriority() ),
                Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldArguments() ) );

        $queue->setId( intval( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldId() ) ) );
        $queue->setOccurence( intval( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldOccurence() ) ) );
        $queue->setError( intval( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldError() ) ) );
        $queue->setBuildingId( intval( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldBuildingId() ) ) );

        $queue->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldUpdated() ) ) );
        $queue->setRegistered(
                Core::parseTimestamp( Core::arrayAt( $queueArray, Resource::db()->queue()->getFieldRegistered() ) ) );

        // Return Queue
        return $queue;

    }

    /**
     * @param array $queue_list
     * @return QueueListModel
     */
    private static function createQueueList( array $queueListArray )
    {

        // Initiate objects
        $queueList = new QueueListModel();

        // Foreach objects
        foreach ( $queueListArray as $queueArray )
        {
            $queueList->add( self::createQueue( $queueArray ) );
        }

        // Return objects
        return $queueList;

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
        $select_build->setFrom( Resource::db()->queue()->getTable() );

        $select_query->setQuery( $select_build );

        // Return query
        return $select_query;

    }

    /**
     * @param QueueModel $queue
     * @param unknown_type $isInsert
     */
    private function getInsertUpdateFieldsBinds( QueueModel $queue, $isInsert = false )
    {

        $fields = array ();
        $binds = array ();

        $fields[ Resource::db()->queue()->getFieldType() ] = ":type";
        $binds[ "type" ] = $queue->getType();
        $fields[ Resource::db()->queue()->getFieldPriority() ] = ":priority";
        $binds[ "priority" ] = $queue->getPriority();
        $fields[ Resource::db()->queue()->getFieldArguments() ] = ":arguments";
        $binds[ "arguments" ] = QueueUtil::generateArgumentsToString( $queue->getArguments() );

        if ( $queue->getOccurence() )
        {
            $fields[ Resource::db()->queue()->getFieldOccurence() ] = ":occurence";
            $binds[ "occurence" ] = $queue->getOccurence();
        }

        if ( $queue->getBuildingId() )
        {
            $fields[ Resource::db()->queue()->getFieldBuildingId() ] = ":buildingId";
            $binds[ "buildingId" ] = $queue->getBuildingId();
        }
        else
        {
            $fields[ Resource::db()->queue()->getFieldBuildingId() ] = SB::$NULL;
        }

        if ( !$isInsert )
        {
            $fields[ Resource::db()->queue()->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );

    }

    // ... /GET


    /**
     * @see ActorDao::getQueue()
     */
    public function get( $queueId )
    {

        // Select query
        $select_query = self::getSelectQuery();

        // ... Build
        $select_build = SelectSqlbuilderDbCore::get_( $select_query->getQuery() );
        $select_build->setWhere( SB::equ( Resource::db()->queue()->getFieldId(), ":queue_id" ) );

        // ... Binds
        $select_query->setBinds( array ( "queue_id" => $queueId ) );

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return count( $result->getRows() ) > 0 ? $this->createQueue( $result->getRow( 0 ) ) : null;

    }

    /**
     * @see QueueDao::getDuplicate()
     */
    public function getDuplicate( QueueModel $queue )
    {

        $binds = array ();

        // Select query
        $select_query = new SelectQueryDbCore();

        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( "*" );
        $select_build->setFrom( Resource::db()->queue()->getTable() );
        $select_build->addWhere( SB::equ( Resource::db()->queue()->getFieldType(), ":type" ) );

        // ... ... Building
        if ( $queue->getBuildingId() )
        {
            $select_build->addWhere( SB::equ( Resource::db()->queue()->getFieldBuildingId(), ":buildingId" ) );
            $binds[ "buildingId" ] = $queue->getBuildingId();
        }

        $select_query->setQuery( $select_build );

        // ... Binds
        $binds[ "type" ] = $queue->getType();

        $select_query->setBinds( $binds );

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return count( $result->getRows() ) > 0 ? $this->createQueue( $result->getRow( 0 ) ) : null;

    }

    /**
     * @see QueueDao::getNext()
     */
    public function getNext( array $queueTypes = array() )
    {

        $binds = array ();

        // Select query
        $select_query = new SelectQueryDbCore();

        // ... Build
        $select_build = new SelectSqlbuilderDbCore();
        $select_build->setExpression( "*" );
        $select_build->setFrom( Resource::db()->queue()->getTable() );
        $select_build->setOrderBy(
                        array (
                                array ( Resource::db()->queue()->getFieldError(), SB::$ASC ),
                                array ( Resource::db()->queue()->getFieldPriority(), SB::$DESC ),
                                array ( Resource::db()->queue()->getFieldRegistered(), SB::$ASC ),
                                array ( Resource::db()->queue()->getFieldId(), SB::$ASC ) ) );

        // ... ... Types
        if ( !empty( $queueTypes ) )
        {
            list ( $typeFields, $typeBinds ) = SB::createIn( Resource::db()->queue()->getFieldType(), $queueTypes );
            $select_build->addWhere( SB::in( Resource::db()->queue()->getFieldType(), $typeFields ) );
            $binds += $typeBinds;
        }

        $select_query->setQuery( $select_build );

        // ... Binds
        $select_query->setBinds( $binds );

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return count( $result->getRows() ) > 0 ? $this->createQueue( $result->getRow( 0 ) ) : null;

    }

    /**
     * @see QueueDao::getQueueList()
     */
    public function getList()
    {

        // Select query
        $select_query = self::getSelectQuery();

        // Do select
        $result = $this->getDbApi()->query( $select_query );

        // Return created object
        return self::createQueueList( $result->getRows() );

    }

    /**
     * @see QueueDao::addQueue()
     */
    public function add( QueueModel $queue )
    {

        // Insert query
        $insert_query = new InsertQueryDbCore();

        // ... Fields, binds
        list ( $fields, $binds ) = $this->getInsertUpdateFieldsBinds( $queue, true );

        // ... Build
        $insert_build = new InsertSqlbuilderDbCore();
        $insert_build->setInto( Resource::db()->queue()->getTable() );
        $insert_build->setSetValues( $fields );

        $insert_query->setQuery( $insert_build );

        // ... Bind
        $insert_query->setBinds( $binds );

        // Do insert
        $result = $this->getDbApi()->query( $insert_query );

        // Return object id
        return $result->getInsertId();

    }

    /**
     * @see QueueDao::edit()
     */
    public function edit( $queueId, QueueModel $queue )
    {

        // Update query
        $update_query = new UpdateQueryDbCore();

        // ... Fields, binds
        list ( $fields, $binds ) = $this->getInsertUpdateFieldsBinds( $queue, false );

        // ... Build
        $update_build = new UpdateSqlbuilderDbCore();
        $update_build->setTable( Resource::db()->queue()->getTable() );
        $update_build->setSet( $fields );
        $update_build->setWhere( SB::equ( Resource::db()->queue()->getFieldId(), ":id" ) );

        $update_query->setQuery( $update_build );

        // ... Bind
        $update_query->setBinds( array_merge( array ( "id" => $queueId ), $binds ) );

        // Do update
        $result = $this->getDbApi()->query( $update_query );

        // Return boolean
        return $result->isExecute();

    }

    /**
     * @see QueueDao::increaseError()
     */
    public function increaseError( $queueId )
    {

        // Update query
        $update_query = new UpdateQueryDbCore(
                new UpdateSqlbuilderDbCore( Resource::db()->queue()->getTable(),
                        array (
                                Resource::db()->queue()->getFieldError() => SB::add(
                                        Resource::db()->queue()->getFieldError(), "1" ) ),
                        SB::equ( Resource::db()->queue()->getFieldId(), ":id" ) ), array ( "id" => $queueId ) );

        // Do update
        $result = $this->getDbApi()->query( $update_query );

        // Return boolean
        return $result->isExecute();

    }

    /**
     * @see QueueDao::remove()
     */
    public function remove( $queueId )
    {

        // Delete query
        $delete_query = new DeleteQueryDbCore(
                new DeleteSqlbuilderDbCore( Resource::db()->queue()->getTable(),
                        SB::equ( Resource::db()->queue()->getFieldId(), $queueId ) ) );

        // Do delete
        $result = $this->getDbApi()->query( $delete_query );

        // Return number of removed objects
        return $result->getAffectedRows();

    }

    /**
     * @see QueueDao::removeAll()
     */
    public function removeAll()
    {

        // Delete query
        $delete_query = new DeleteQueryDbCore( new DeleteSqlbuilderDbCore( Resource::db()->queue()->getTable() ) );

        // Do delete
        $result = $this->getDbApi()->query( $delete_query );

        // Return number of removed objects
        return $result->getAffectedRows();

    }

    // /FUNCTIONS


}

?>