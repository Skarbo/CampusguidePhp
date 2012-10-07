<?php

abstract class SidebarBuildingcreatorBuildingsCmsPresenterView extends AbstractPresenterView implements BuildingcreatorBuildingsCmsInterfaceView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPresenterView::getView()
     * @return BuildingcreatorBuildingsCmsPageMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see BuildingsCmsInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getView()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getView()->getBuildingFloors();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->getView()->getBuildingElements();
    }

    // ... /GET


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

    }

    // /FUNCTIONS


}

?>