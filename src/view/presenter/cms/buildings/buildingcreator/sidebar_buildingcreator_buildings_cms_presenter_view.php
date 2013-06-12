<?php

abstract class SidebarBuildingcreatorBuildingsCmsPresenterView extends PresenterView implements BuildingcreatorBuildingsCmsInterfaceView
{

    // VARIABLES


    private $infoPanelContent = array ();

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
        return $this->getController()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getController()->getBuildingFloors();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->getController()->getBuildingElements();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getFacility()
     */
    public function getFacility()
    {
        return $this->getController()->getFacility();
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
                "data-sidebar-group",
                is_array( $this->getSidebarGroups() ) ? implode( " ", $this->getSidebarGroups() ) : $this->getSidebarGroups() );

        // Draw header
        $header = Xhtml::div()->class_( Resource::css()->getTable(), "sidebar_header_wrapper", "collapse" );
        $this->drawHeader( $header );

        // Draw content
        $content = Xhtml::div()->class_( "sidebar_content" );
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

    /**
     * @param AbstractXhtml $root
     */
    public function drawInfoPanelContent( AbstractXhtml $root )
    {
        foreach ( $this->infoPanelContent as $infoPanelContent )
        {
            $root->addContent( $infoPanelContent );
        }
    }

    /**
     * @param String $infoPanelId
     * @param String $infoPanelGroup
     * @param String $headerField
     * @param AbstractXhtml $infoPanelContent
     */
    public function addInfoPanelContent( $infoPanelId, $infoPanelGroup, $headerField, AbstractXhtml $infoPanelContent )
    {

        $wrapper = Xhtml::div()->class_( "info_panel_content_wrapper" );
        $wrapper->attr( "data-infopanel-group", $infoPanelGroup );
        $wrapper->attr( "data-infopanel", $infoPanelId );

        // HEADER


        $headerWrapper = Xhtml::div()->class_( "info_panel_content_header_wrapper", Resource::css()->getTable() );
        $headerWrapper->addContent( Xhtml::div( $headerField )->class_( "info_panel_content_header_field" ) );
        $headerWrapper->addContent( Xhtml::div( "Value" )->class_( "info_panel_content_header_value", Resource::css()->getRight() ) );
        $headerWrapper->addContent( Xhtml::div( Xhtml::img( Resource::image()->getEmptyImage() ) )->class_( "info_panel_content_header_arrow" ) );
        $wrapper->addContent( $headerWrapper );

        // /HEADER


        // CONTENT


        $contentWrapper = Xhtml::div()->class_( "info_panel_content_content_wrapper" );
        $contentWrapper->addContent( $infoPanelContent );
        $wrapper->addContent( $contentWrapper );

        // /CONTENT


        $this->infoPanelContent[] = $wrapper;

    }

    // /FUNCTIONS


}

?>