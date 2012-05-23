<?php

abstract class QueueDao extends Dao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Get Queue
     *
     * @param int $queueId
     * @return QueueModel
     * @throws DbException
     */
    public abstract function get( $queueId );

    /**
     * Get duplicated Queue
     *
     * @param QueueModel $queue
     * @return QueueModel Duplicated Queue
     * @throws DbException
     */
    public abstract function getDuplicate( QueueModel $queue );

    /**
     * Get next Queue for given types
     *
     * @param array $queueTypes
     * @return QueueModel
     * @throws DbException
     */
    public abstract function getNext( array $queueTypes = array() );

    /**
     * Get Queue List
     *
     * @return QueueListModel
     * @throws DbException
     */
    public abstract function getList();

    /**
     * Add Queue
     *
     * @param QueueModel $academy
     * @return int Queue id
     * @throws DbException
     */
    public abstract function add( QueueModel $queue );

    /**
     * Edit Queue
     *
     * @param int $queueId Original id
     * @param QueueModel $academy
     * @return boolean True if updated
     * @throws DbException
     */
    public abstract function edit( $queueId, QueueModel $queue );

    /**
     * Increase Queue error
     *
     * @param int $queueId
     * @return boolean True if increased
     * @throws DbException
     */
    public abstract function increaseError( $queueId );

    /**
     * Remove Queue
     *
     * @param int $queueId Queue id
     * @return boolean True if removed
     * @throws DbException
     */
    public abstract function remove( $queueId );

    /**
     * Remove all Queue
     *
     * @return int Number of removed Queue
     * @throws DbException
     */
    public abstract function removeAll();

    // /FUNCTIONS


}

?>