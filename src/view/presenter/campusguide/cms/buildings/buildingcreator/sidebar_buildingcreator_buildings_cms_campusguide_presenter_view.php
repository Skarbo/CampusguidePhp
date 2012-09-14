<?php

abstract class SidebarBuildingcreatorBuildingsCmsCampusguidePresenterView extends PresenterView implements BuildingcreatorBuildingsCmsCampusguideInterfaceView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PresenterView::getView()
     * @return BuildingcreatorBuildingsCmsCampusguidePageMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see BuildingsCmsCampusguideInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getView()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsCampusguideInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getView()->getBuildingFloors();
    }

    /**
     * @see BuildingcreatorBuildingsCmsCampusguideInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->getView()->getBuildingElements();
    }

    // ... /GET


    /**
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

    }

    // /FUNCTIONS


}

?>