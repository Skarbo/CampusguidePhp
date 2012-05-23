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

        // Draw map to wrapper
        $this->drawMap( $wrapper );

        // Draw building slider to wrapper
        $this->drawBuildingSlider( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    protected function drawMenu( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        $table->addContent(
                Xhtml::div( Xhtml::a( "" )->href( "#" )->attr( "data-icon", "search" )->title( "Search" ) ) );
        $table->addContent(
                Xhtml::div(
                        Xhtml::a( "" )->href( "#" )->id( "menu_button_location" )->attr( "data-icon", "location" )->title(
                                "Location" ) ) );
        $table->addContent(
                Xhtml::div( Xhtml::a( "" )->href( "#" )->attr( "data-icon", "layers" )->title( "Layers" ) ) );
        $table->addContent( Xhtml::div( Xhtml::a( "" )->href( "#" )->attr( "data-icon", "more" )->title( "More" ) ) );

        // Add table to root
        $root->addContent( $table );

        // Sub menu
        $sub = Xhtml::div( Xhtml::div( "Sub menu" ) )->class_( "sub" );
        $root->addContent( $sub );

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
        $mapCanvas = Xhtml::div()->id( self::$ID_MAP_CANVAS )->class_( Resource::css()->getHide() );

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
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "direction" ) )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "Take me there" )->href( "#" )->target( AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $menu->addContent( $row );

        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "home" ) )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "See building" )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() ) ) );
        $menu->addContent( $row );

        // /MENU


        // Draw overlay
        $this->getOverlayPresenter()->setId( self::$ID_MAP_BUILDING_OVERLAY );
        $this->getOverlayPresenter()->setFitParent( "true" );
        $this->getOverlayPresenter()->setTitle( "Header" );
        $this->getOverlayPresenter()->setBody( $menu );
        $this->getOverlayPresenter()->draw( $root );

        //         // Create wrapper
        //         $wrapper = Xhtml::div()->id( "overlay_wrapper" )->attr( "data-fitparent",
        //                 sprintf( "#%s", AppCampusguideMainView::$ID_PAGE_WRAPPER ) );


        //         $table = Xhtml::div()->class_( Resource::css()->getTable() );
        //         $cell = Xhtml::div();


        //         $overlay = Xhtml::div()->class_( "overlay" );
        //         $overlay->addContent( Xhtml::h( 2, "Header" ) );
        //         $body = Xhtml::div();


        //         $menu = Xhtml::div()->class_( Resource::css()->getTable(), "menu" );


        //         $row = Xhtml::div()->class_( Resource::css()->getTableRow() );
        //         $row->addContent( Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "direction" ) ) );
        //         $row->addContent( Xhtml::div( "Take me there" ) );
        //         $menu->addContent( $row );


        //         $row = Xhtml::div()->class_( Resource::css()->getTableRow() );
        //         $row->addContent( Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "home" ) ) );
        //         $row->addContent( Xhtml::div( "See building" ) );
        //         $menu->addContent( $row );


        //         $body->addContent( $menu );
        //         $overlay->addContent( $body );


        //         $cell->addContent( $overlay );
        //         $table->addContent( $cell );
        //         $wrapper->addContent( $table );


        //         $root->addContent( $wrapper );


    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawBuildingSlider( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( "building_slider_wrapper" )->class_(Resource::css()->getHide());

        $div = Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "home" ) )->class_( "building" );

        $wrapper->addContent( $div );

        $root->addContent( $wrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>