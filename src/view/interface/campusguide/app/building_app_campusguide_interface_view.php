<?php

interface BuildingAppCampusguideInterfaceView extends InterfaceView
{

    /**
     * @return FacilityModel
     */
    public function getFacility();

    /**
     * @return BuildingModel
     */
    public function getBuilding();

}

?>