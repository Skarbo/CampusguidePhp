<?php

class ViewFacilityFacilitiesCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    private static $ID_VIEW_FACILITY_PAGE_WRAPPER = "view_facility_page_wrapper";
    private static $ID_BUILDINGS_MAP_WRAPPER = "buildings_map_wrapper";
    private static $ID_BUILDINGS_WRAPPER = "buildings_wrapper";
    private static $ID_MAP_WRAPPER = "map_wrapper";
    private static $ID_MAP_CANVAS = "map_canvas";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PageMainView::getView()
     * @return FacilitiesCmsCampusguideMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @return FacilityModel
     */
    private function getFacility()
    {
        return $this->getView()->getController()->getFacility();
    }

    /**
     * @return BuildingListModel
     */
    private function getBuildings()
    {
        return $this->getView()->getController()->getBuildings();
    }

    // ... /GET


    /**
     * @see FacilityFacilitiesCmsCampusguidePageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_VIEW_FACILITY_PAGE_WRAPPER );

        // HEADER/SUBMENU


        // Create header table
        $headerTable = Xhtml::div()->class_( Resource::css()->getTable() );

        // Add header to header table
        $headerTable->addContent(
                Xhtml::div( Xhtml::h( 2, sprintf( "Facility: %s", $this->getFacility()->getName() ) ) )->class_(
                        Resource::css()->getTableCell() ) );

        // Draw sub menu
        $headerTableCell = Xhtml::div()->class_( Resource::css()->getTableCell(), Resource::css()->getRight() );

        // Buttons gui
        $buttonsGui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui() );

        // Delete button
        $buttonsGui->addContent(
                Xhtml::a( "Delete" )->href(
                        Resource::url()->campusguide()->cms()->facility()->getDeleteFacilityPage(
                                array ( $this->getFacility()->getId() ), $this->getView()->getController()->getMode() ) )->title(
                        "Delete" )->addClass( Resource::css()->gui()->getComponent() ) );

        // Edit button
        $buttonsGui->addContent(
                Xhtml::a( "Edit" )->href(
                        Resource::url()->campusguide()->cms()->facility()->getEditFacilityPage(
                                $this->getFacility()->getId(), $this->getView()->getController()->getMode() ) )->title(
                        "Edit" )->addClass( Resource::css()->gui()->getComponent() ) );

        $headerTableCell->addContent( $buttonsGui );

        $headerTable->addContent( $headerTableCell );

        // Add header to page wrapper
        $pageWrapper->addContent(
                Xhtml::div( $headerTable )->class_( Resource::css()->campusguide()->cms()->page()->getHeaderWrapper() ) );

        // /HEADER/SUBMENU


        // Draw Faciity Buildings
        $buildingsMapWrapper = Xhtml::div()->id( self::$ID_BUILDINGS_MAP_WRAPPER )->class_(
                Resource::css()->getTable() );
        $this->drawBuildings( $buildingsMapWrapper );
        $this->drawMap( $buildingsMapWrapper );
        $pageWrapper->addContent( $buildingsMapWrapper );

        // Add wrapper to root
        $root->addContent( $pageWrapper );

    }

    private function drawBuildings( AbstractXhtml $root )
    {

        // Wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGS_WRAPPER );

        // Create header
        $wrapper->addContent(
                Xhtml::h( 3,
                        sprintf( "%s (%s)",
                                $this->getLocale()->quantity( $this->getFacility()->getBuildings() == 1,
                                        $this->getLocale()->building()->getBuilding(),
                                        $this->getLocale()->building()->getBuildings() ),
                                $this->getFacility()->getBuildings() ) ) );

        // Create table
        $table = Xhtml::table()->class_( "buildings_table" );

        // Create head
        $head = Xhtml::thead()->class_( "buildings_table_header" );

        // Create row
        $row = Xhtml::tr();

        $row->addContent( Xhtml::td( "Overview" )->class_( "overview" ) );
        $row->addContent( Xhtml::td( "Building" )->class_( "building" ) );

        $head->addContent( $row );
        $table->addContent( $head );

        // Create body
        $body = Xhtml::tbody()->class_( "buildings_table_body" );

        // ...  Foreach Buildings
        for ( $this->getBuildings()->rewind(); $this->getBuildings()->valid(); $this->getBuildings()->next() )
        {
            $building = $this->getBuildings()->current();

            // Create row
            $row = Xhtml::tr()->id( sprintf( "building_%s", $building->getId() ) )->class_("buildings_row_building");

            // Create overview
            $cell = Xhtml::td()->class_( "overview" );

            // ... Image
            $img = Xhtml::img()->src(
                    Resource::url()->campusguide()->cms()->building()->getImageController( $building->getId(), 100, 75,
                            $this->getView()->getController()->getMode() ) );

            $cell->addContent( $img );
            $row->addContent( $cell );

            // Create building
            $cell = Xhtml::td()->class_( "building" );

            // ... Name
            $name = Xhtml::div(
                    Xhtml::a( $building->getName() )->href(
                            Resource::url()->campusguide()->cms()->building()->getViewBuildingPage( $building->getId(),
                                    $this->getView()->getController()->getMode() ) ) )->class_( "title" );

            // ... Address
            $address = Xhtml::div( implode( ", ", Core::empty_( $building->getAddress(), array () ) ) )->class_(
                    "address" );

            // ... Floors
            $floors = Xhtml::div(
                    sprintf( "%s %s", $building->getFloors(),
                            strtolower(
                                    $this->getLocale()->quantity( $building->getFloors(),
                                            $this->getLocale()->building()->getFloor(),
                                            $this->getLocale()->building()->getFloors() ) ) ) )->class_( "floors" );

            $cell->addContent( $name );
            $cell->addContent( $address );
            $cell->addContent( $floors );
            $row->addContent( $cell );

            $body->addContent( $row );

        }

        $table->addContent( $body );

        // Create foot
        $foot = Xhtml::tfoot( Xhtml::tr( Xhtml::td( "No buildings" )->colspan( 2 ) ) )->class_(
                $this->getFacility()->getBuildings() > 0 ? Resource::css()->campusguide()->cms()->getHide() : "buildings_table_footer" );

        $table->addContent( $foot );

        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    private function drawMap( AbstractXhtml $root )
    {

        // Wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_WRAPPER );

        // Create header
        $wrapper->addContent( Xhtml::h( 3, "Map" ) );

        // Create map canvas
        $wrapper->addContent( Xhtml::div()->id( self::$ID_MAP_CANVAS ) );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>