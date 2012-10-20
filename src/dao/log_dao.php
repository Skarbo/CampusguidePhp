<?php

abstract class LogDao extends Dao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

	/**
     * Get Log
     *
     * @param int $logId
     * @return LogModel
     */
    public abstract function get( $logId );

    /**
     * Get Log List
     *
     * @return LogListModel
     */
    public abstract function getList();

    /**
     * Add Log
     *
     * @param LogModel $academy
     * @return int Log id
     */
    public abstract function add( LogModel $log );

    /**
     * Remove all Log
     *
     * @return int Number of removed Log
     */
    public abstract function removeAll();

    // /FUNCTIONS


}

?>