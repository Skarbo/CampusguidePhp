<?php

interface TypeScheduleDao extends StandardDao
{

    // VARIABLES

    // /VARIABLES

    // CONSTRUCTOR

    // /CONSTRUCTOR

    // FUNCTIONS

    /**
     * @param integer $entryId
     * @param integer $typeId
     * @return boolean True if added
     */
    public function addEntry( $entryId, $typeId );

    /**
     * @param integer Website id
     * @param TypeScheduleModel $type
     * @return TypeScheduleModel Duplicate Type, null if none
     */
    public function getDuplicate( $websiteId, TypeScheduleModel $type );

    // /FUNCTIONS

}


?>