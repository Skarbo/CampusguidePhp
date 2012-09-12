<?php

interface ElementBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Elements for given Building
     *
     * @param int $buildingId
     * @return ElementBuildingListModel
     */
    public function getBuilding( $buildingId );

    // /FUNCTIONS


}

?>