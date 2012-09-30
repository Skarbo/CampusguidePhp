<?php

interface EntryScheduleDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param integer $entryId
     * @param integer $occurence Unixtime
     */
    public function addOccurence( $entryId, $occurence );

    // /FUNCTIONS


}

?>