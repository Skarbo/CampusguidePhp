<?php

interface FloorplannerBuildingsCmsInterfaceView extends BuildingsCmsInterfaceView
{

    /**
     * @return FloorBuildingListModel
     */
    public function getBuildingFloors();

}

?>