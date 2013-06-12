<?php

interface BuildingcreatorBuildingsCmsInterfaceView extends BuildingsCmsInterfaceView
{

    /**
     * @return FloorBuildingListModel
     */
    public function getBuildingFloors();

    /**
     * @return ElementBuildingListModel
     */
    public function getBuildingElements();

    /**
     * @return FacilityModel
     */
    public function getFacility();

}

?>