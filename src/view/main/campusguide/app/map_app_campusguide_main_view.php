<?php

class MapAppCampusguideMainView extends AppCampusguideMainView
{

    // VARIABLES


    /**
     * @var OverlayAppCampusguidePresenterView
     */
    private $overlayPresenter;

    private static $ID_MAP_PAGE_WRAPPER = "map_page_wrapper";
    private static $ID_MAP_WRAPPER = "map_wrapper";
    private static $ID_MAP_CANVAS = "map_canvas";
    private static $ID_MAP_LOADER = "map_loader";
    private static $ID_MAP_BUILDING_OVERLAY = "map_building_overlay";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverlayAppCampusguidePresenterView
     */
    private function getOverlayPresenter()
    {
        return $this->overlayPresenter;
    }

    /**
     * @param OverlayAppCampusguidePresenterView $overlayPresenter
     */
    private function setOverlayPresenter( OverlayAppCampusguidePresenterView $overlayPresenter )
    {
        $this->overlayPresenter = $overlayPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... /GET


    /**
     * @see View::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverlayPresenter( new OverlayAppCampusguidePresenterView( $this ) );
    }

    // ... DRAW


    /**
     * @see AppCampusguideMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", AppCampusguideMainView::$ID_PAGE_WRAPPER ) );

        // Draw overlay to wrapper
        $this->drawOverlay( $wrapper );

        // Draw search overlay to wrapper
        $this->drawOverlaySearch( $wrapper );

        // Draw map to wrapper
        $this->drawMap( $wrapper );

        // Draw building slider to wrapper
        $this->drawBuildingSlider( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {

        //         // Create table
        //         $table = Xhtml::div()->class_( Resource::css()->getTable(), "menu_buttons" );


        //         // MENU


        //         // Search
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->id( "menu_button_search" )->attr( "data-icon", "search" )->title( "Search" )->class_(
        //                                 Resource::css()->campusguide()->app()->getTouch() ) ) );


        //         // Location
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->id( "menu_button_location" )->attr( "data-icon", "location" )->title(
        //                                 "Location" )->class_( Resource::css()->campusguide()->app()->getTouch() ) ) );


        //         // Layers
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->attr( "data-icon", "layers" )->title( "Layers" )->class_(
        //                                 Resource::css()->campusguide()->app()->getTouch() ) ) );


        //         // More
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
        //                                 Resource::css()->campusguide()->app()->getTouch() ) ) );


        //         // /MENU


        //         // Add table to root
        //         $rootTop->addContent( $table );


        //         // Sub menu
        //         $menuSub = Xhtml::div()->attr( "data-fitparent-width", "true" )->class_( "sub_wrapper",
        //                 Resource::css()->getHide() );
        //         $this->drawMenuSub( $menuSub );
        //         $rootTop->addContent( $menuSub );


        // ACTION BAR


        $this->getActionbarPresenter()->setIcon( Xhtml::div()->attr( "data-icon", "map" ) );
        $this->getActionbarPresenter()->setViewControl( Xhtml::div( "Map" )->id( "actionbar_viewcontrol_map" ) );

        // Search
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "search" )->title( "Search" )->class_(
                        Resource::css()->campusguide()->app()->getTouch(), "button", "menu_button_search" ) );

        // Location
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "location" )->title( "Location" )->class_(
                        Resource::css()->campusguide()->app()->getTouch(), "button", "menu_button_location" ) );

        // More
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
                        Resource::css()->campusguide()->app()->getTouch(), "button", "menu_button_more" ) );

        // Location pin
        $this->getActionbarPresenter()->addMenu( Xhtml::div( Xhtml::div()->attr( "data-icon", "location_pin" ) )->addContent(
                Xhtml::div( "Pin location" ) )->id("actionbar_menu_locationpin") );

        // Buildings
        $this->getActionbarPresenter()->addViewControlMenu(
                Xhtml::div( Xhtml::div()->attr( "data-icon", "home" ) )->addContent( Xhtml::div( "Buildings" ) )->id("actionbar_menu_buildings") );

        $this->getActionbarPresenter()->draw( $rootTop );
        $this->getActionbarPresenter()->drawBottom( $rootBottom );

        // /ACTION BAR


        // Sub menu
        //         $menuSub = Xhtml::div()->attr( "data-fitparent-width", "true" )->class_( "sub_wrapper",
        //                 Resource::css()->getHide() );
        //         $this->drawMenuSub( $menuSub );
        //         $rootTop->addContent( $menuSub );


    }

    protected function drawMenuSub( AbstractXhtml $root )
    {

        $menu = Xhtml::div()->class_( "sub" );

        // POSITION


        $position = Xhtml::div()->id( "menu_sub_position" )->class_( Resource::css()->getHide() );

        $row = Xhtml::div()->id( "menu_sub_position_setposition" )->class_(
                Resource::css()->campusguide()->app()->getTouch() );
        $row->addContent( Xhtml::div( Xhtml::div()->attr( "data-icon", "location_pin" ) ) );
        $row->addContent( Xhtml::div( "Set position" ) );

        $position->addContent( $row );
        $menu->addContent( Xhtml::div( $position ) );

        // /POSITION


        $root->addContent( Xhtml::div()->class_( "arrow" )->attr( "data-arrow", "up" ) );
        $root->addContent( $menu );
        $root->addContent( Xhtml::div()->class_( "arrow" )->attr( "data-arrow", "down" ) );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawMap( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_WRAPPER );

        // Create map loader wrapper
        $mapLoaderWrapper = Xhtml::div(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading map" ) )->addContent(
                        Xhtml::div( "Loading map..." ) ) )->id( self::$ID_MAP_LOADER )->class_(
                Resource::css()->getTable() );
        $wrapper->addContent( $mapLoaderWrapper );

        // Create map canvas
        $mapCanvas = Xhtml::div()->id( self::$ID_MAP_CANVAS )->class_( Resource::css()->getHide() )->attr(
                "data-fitparent", "#map_page_wrapper" );

        // Add map canvas to wrapper
        $wrapper->addContent( $mapCanvas );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawOverlay( AbstractXhtml $root )
    {

        // MENU


        $menu = Xhtml::div()->class_( Resource::css()->campusguide()->app()->getOverlayMenu() );

        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "direction" ) )->href( "#" )->target(
                                AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "Take me there" )->href( "#" )->target( AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $menu->addContent( $row );

        // View building
        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "home" ) )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() )->attr( "data-url",
                                Resource::url()->campusguide()->app()->building()->getBuilding( "%s", $this->getMode() ) ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "See building" )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() )->attr( "data-url",
                                Resource::url()->campusguide()->app()->building()->getBuilding( "%s", $this->getMode() ) ) ) );
        $menu->addContent( $row );

        // /MENU


        // Draw overlay
        $this->getOverlayPresenter()->setId( self::$ID_MAP_BUILDING_OVERLAY );
        $this->getOverlayPresenter()->setFitParent( "true" );
        $this->getOverlayPresenter()->setTitle( "Header" );
        $this->getOverlayPresenter()->setBody( $menu );
        $this->getOverlayPresenter()->draw( $root );

    }

    /**
     * @see AppCampusguideMainView::drawOverlaySearchTemplate()
     */
    protected function drawOverlaySearchTemplate( AbstractXhtml $root )
    {

        // Building template
        $searchResultTableTemplateBuilding = Xhtml::tbody()->class_( "search_result_body",
                Resource::css()->getHide() )->id( "search_result_template_building" );

        $searchResultTableRowFirst = Xhtml::tr()->class_( "search_result_row_first" );
        $searchResultTableRowSecond = Xhtml::tr()->class_( "search_result_row_second" );

        // ... Icon
        $searchResultTableCellIcon = Xhtml::td()->class_( "search_result_icon" );
        $searchResultTableCellIcon->addContent( Xhtml::div()->attr( "data-icon", "home" ) );

        // ... Title
        $searchResultTableCellTitle = Xhtml::td( "Building" )->class_( "search_result_title" );

        // ... Description
        $searchResultTableCellDescription = Xhtml::td( "Description" )->colspan( 3 )->class_(
                "search_result_description" );

        // ... Direction
        $searchResultTableCellDirection = Xhtml::td( "000m" )->class_( "search_result_direction" );

        $searchResultTableRowFirst->addContent( $searchResultTableCellIcon )->addContent( $searchResultTableCellTitle )->addContent(
                $searchResultTableCellDirection );
        $searchResultTableRowSecond->addContent( $searchResultTableCellDescription );
        $searchResultTableTemplateBuilding->addContent( $searchResultTableRowFirst );
        $searchResultTableTemplateBuilding->addContent( $searchResultTableRowSecond );
        $root->addContent( $searchResultTableTemplateBuilding );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawBuildingSlider( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( "building_slider_wrapper" )->class_( Resource::css()->getHide() )->attr(
                "data-url", Resource::url()->campusguide()->app()->building()->getBuilding( "%s", $this->getMode() ) );

        $div = Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "home" ) )->class_( "building" );

        $wrapper->addContent( $div );

        $root->addContent( $wrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>