<?php

class MapAppMainView extends AppMainView
{

    // VARIABLES


    /**
     * @var OverlayAppPresenterView
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
     * @return OverlayAppPresenterView
     */
    private function getOverlayPresenter()
    {
        return $this->overlayPresenter;
    }

    /**
     * @param OverlayAppPresenterView $overlayPresenter
     */
    private function setOverlayPresenter( OverlayAppPresenterView $overlayPresenter )
    {
        $this->overlayPresenter = $overlayPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... /GET


    /**
     * @see AbstractView::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverlayPresenter( new OverlayAppPresenterView( $this ) );
    }

    // ... DRAW


    /**
     * @see AppMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", AppMainView::$ID_PAGE_WRAPPER ) );

        // Draw overlay to wrapper
        $this->drawOverlay( $wrapper );

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
        //                                 Resource::css()->app()->getTouch() ) ) );


        //         // Location
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->id( "menu_button_location" )->attr( "data-icon", "location" )->title(
        //                                 "Location" )->class_( Resource::css()->app()->getTouch() ) ) );


        //         // Layers
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->attr( "data-icon", "layers" )->title( "Layers" )->class_(
        //                                 Resource::css()->app()->getTouch() ) ) );


        //         // More
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
        //                                 Resource::css()->app()->getTouch() ) ) );


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
        $this->getActionbarPresenter()->addViewControl( Xhtml::div( "Map" )->id( "actionbar_viewcontrol_map" ) );

        // Search
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "search" )->title( "Search" )->class_("menu_button_search" ) );

        // Location
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "location" )->title( "Location" )->class_("menu_button_location" ) );

        // More
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_( "menu_button_more" ) );

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
                Resource::css()->app()->getTouch() );
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


        $menu = Xhtml::div()->class_( Resource::css()->app()->getOverlayMenu() );

        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "direction" ) )->href( "#" )->target(
                                AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->getGoogleDirections() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "Take me there" )->href( "#" )->target( AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->getGoogleDirections() ) ) );
        $menu->addContent( $row );

        // View building
        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "home" ) )->href( "#" )->class_(
                                Resource::css()->app()->map()->getMenuView() )->attr( "data-url",
                                Resource::url()->app()->building()->getBuilding( "%s", $this->getMode() ) ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "See building" )->href( "#" )->class_(
                                Resource::css()->app()->map()->getMenuView() )->attr( "data-url",
                                Resource::url()->getGoogleDirections() )->attr( "data-url",
                                Resource::url()->app()->building()->getBuilding( "%s", $this->getMode() ) ) ) );
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
     * @param AbstractXhtml $root
     */
    protected function drawBuildingSlider( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( "building_slider_wrapper" )->class_( Resource::css()->getHide() )->attr(
                "data-url", Resource::url()->app()->building()->getBuilding( "%s", $this->getMode() ) );

        $div = Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "home" ) )->class_( "building" );

        $wrapper->addContent( $div );

        $root->addContent( $wrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>