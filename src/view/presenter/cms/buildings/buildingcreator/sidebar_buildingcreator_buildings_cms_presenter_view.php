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
     * @return BuildingsCmsMainController
     */
    public function getController()
    {
        return parent::getController();
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

    /**
     * @return string Sidebar type
     */
    protected abstract function getSidebarType();

    /**
     * @return mixed [String|Array] Sidebar groups
     */
    protected abstract function getSidebarGroups();

    // ... /GET


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        // Sidebar
        $sidebar = Xhtml::div()->class_( "sidebar" )->attr( "data-sidebar", $this->getSidebarType() )->attr(
                "data-sidebar-group", is_array($this->getSidebarGroups()) ? implode(" ", $this->getSidebarGroups()) : $this->getSidebarGroups() );

        // Draw header
        $header = Xhtml::div()->class_( Resource::css()->getTable(), "sidebar_header_wrapper", "collapse" );
        $this->drawHeader( $header );

        // Draw content
        $content = Xhtml::div()->class_( "content" );
        $this->drawContent( $content );

        $sidebar->addContent( $header );
        $sidebar->addContent( $content );

        $root->addContent( $sidebar );
    }

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawHeader( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawContent( AbstractXhtml $root );

    // /FUNCTIONS


}

?>