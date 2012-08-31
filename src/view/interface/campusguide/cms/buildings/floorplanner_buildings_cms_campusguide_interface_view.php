<?php

interface FloorplannerBuildingsCmsCampusguideInterfaceView extends BuildingsCmsCampusguideInterfaceView
{

    /**
     * @return FloorBuildingListModel
     */
    public function getBuildingFloors();

}

?>