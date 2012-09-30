<?php

interface ElementBuildingAppCampusguideInterfaceView extends InterfaceView
{

    /**
     * @return FacilityModel
     */
    public function getFacility();

    /**
     * @return BuildingModel
     */
    public function getBuilding();

    /**
     * @return FloorBuildingModel
     */
    public function getFloor();

    /**
     * @return ElementBuildingModel
     */
    public function getElement();

}

?>