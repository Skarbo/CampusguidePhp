<?php

interface BuildingcreatorBuildingsCmsCampusguideInterfaceView extends BuildingsCmsCampusguideInterfaceView
{

    /**
     * @return FloorBuildingListModel
     */
    public function getBuildingFloors();

    /**
     * @return ElementBuildingListModel
     */
    public function getBuildingElements();

}

?>