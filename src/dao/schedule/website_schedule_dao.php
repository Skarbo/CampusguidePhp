<?php

interface WebsiteScheduleDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param integer $websiteId
     * @param integer $buildingIs
     * @return boolean True if added
     */
    public function addBuilding( $websiteId, $buildingId );

    // /FUNCTIONS


}

?>