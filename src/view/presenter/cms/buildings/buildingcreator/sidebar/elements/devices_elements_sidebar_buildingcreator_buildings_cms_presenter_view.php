<?php

class DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView extends SidebarBuildingcreatorBuildingsCmsPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::getSidebarGroups()
     */
    protected function getSidebarGroups()
    {
        return "elements";
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::getSidebarType()
     */
    protected function getSidebarType()
    {
        return "elements_devices";
    }

    // ... /GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        $root->addContent(
                Xhtml::div(
                        Xhtml::img(
                                Resource::image()->building()->element()->getTypeGroup(
                                        ElementBuildingModel::TYPE_GROUP_DEVICE, "#666666" ), "Device" ) ) );
        $root->addContent( Xhtml::h( 1, "Devices" ) );
        $root->addContent( Xhtml::span( $this->getBuildingElements()->size() ) );
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawContent()
     */
    protected function drawContent( AbstractXhtml $root )
    {
        $root->id( "buildingcreator_planner_sidebar_elements_devices" );

        ElementsSidebarBuildingcreatorBuildingsCmsPresenterView::drawElementType( $root, "",
                ElementBuildingModel::TYPE_GROUP_DEVICE, $this->getBuildingFloors(), $this->getBuildingElements() );

        foreach ( ElementBuildingModel::$TYPES_DEVICE as $deviceType )
        {
            ElementsSidebarBuildingcreatorBuildingsCmsPresenterView::drawElementType( $root, $deviceType,
                    ElementBuildingModel::TYPE_GROUP_DEVICE, $this->getBuildingFloors(), $this->getBuildingElements() );
        }

        // Draw info panel
        $this->drawInfoPanel();
    }

    private function drawInfoPanel()
    {

        // DEVICE ROUTER MAC


        $table = Xhtml::table()->class_( "device_router_mac_table" );
        $row = Xhtml::tr()->class_( "device_router_mac_row_wrapper", "template" );
        $row->addContent(
                Xhtml::td(
                        Xhtml::div( Xhtml::input( "", "device_router_mac" )->placeholder( "MAC" ) )->class_(
                                "input_wrapper" ) ) );
        $row->addContent( Xhtml::td( Xhtml::a( Xhtml::img(Resource::image()->icon()->getCrossSvg("#333333", "#333333"), "Remove"), "#" )->title("Remove")->class_( "device_router_mac_remove" ) ) );
        $table->addContent( $row );

        $deviceNameContent = Xhtml::div()->class_( "device_router_mac_wrapper" );
        $deviceNameContent->addContent( $table );
        $deviceNameContent->addContent( Xhtml::a( "Add MAC", "#" )->class_( "device_router_mac_add" ) );

        $this->addInfoPanelContent( "device_router_mac", "device", "MACs", $deviceNameContent );

        // /DEVICE ROUTER MAC


    }

    // /FUNCTIONS


}

?>