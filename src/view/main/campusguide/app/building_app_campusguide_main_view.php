<?php

class BuildingAppCampusguideMainView extends AppCampusguideMainView
{

    // VARIABLES


    private static $ID_BUILDING_PAGE_WRAPPER = "building_page_wrapper";
    private static $ID_BUILDING_CANVAS_WRAPPER = "building_canvas_wrapper";
    private static $ID_BUILDING_CANVAS = "building_canvas";
    private static $ID_BUILDING_LOADER_WRAPPER = "building_loader";
    private static $ID_BUILDING_CANVAS_OVERLAY_WRAPPER = "building_canvas_overlay_wrapper";
    private static $ID_BUILDING_CANVAS_OVERLAY_FLOORS = "building_canvas_overlay_floors";

    /**
     * @var OverlayAppCampusguidePresenterView
     */
    private $overlayPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppCampusguideMainView::getController()
     * @return BuildingAppCampusguideMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AppCampusguideMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDING_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", self::$ID_PAGE_WRAPPER ) );

        // Add canvas div
        $this->drawCanvas( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // MENU


        // Map
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::div()->attr( "data-icon", "left" ) )->addContent(
                                Xhtml::div()->attr( "data-icon", "home" ) )->id( "menu_button_map" )->title(
                                "Back to map" )->class_( Resource::css()->campusguide()->app()->getTouch() ) ) );

        // Building
        $table->addContent( Xhtml::div( "Building" ) );

        // More
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // /MENU


        // Add table to root
        //$rootTop->addContent( $table );


        $this->getActionbarPresenter()->setIcon( Xhtml::div()->attr( "data-icon", "home" ) );
        $this->getActionbarPresenter()->setBackReferer(
                Resource::url()->campusguide()->app()->getMap( $this->getMode() ) );
        $this->getActionbarPresenter()->setViewControl( Xhtml::div( $this->getController()->getBuilding()->getName() ) );
        $this->getActionbarPresenter()->draw( $rootTop );
        $this->getActionbarPresenter()->drawBottom( $rootBottom );

        //         $this->getActionbarPresenter()->addMenu($menu);


    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawCanvas( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_WRAPPER );
        $canvas = Xhtml::div()->id( self::$ID_BUILDING_CANVAS );

        // Loader wrapper
        $loaderWrapper = Xhtml::div()->id( self::$ID_BUILDING_LOADER_WRAPPER )->class_(
                Resource::css()->getTable() );
        $loaderWrapper->addContent(
                Xhtml::div( Xhtml::div( "Loading..." ) )->addContent(
                        Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading" ) )->class_(
                        Resource::css()->getMiddle() ) );

        // Overlay
        $overlayWrapper = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_OVERLAY_WRAPPER );

        $overlayFloors = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_OVERLAY_FLOORS );

        $floorMain = $this->getController()->getFloors()->getMainFloor();
        for ( $this->getController()->getFloors()->rewind(); $this->getController()->getFloors()->valid(); $this->getController()->getFloors()->next() )
        {
            $floor = $this->getController()->getFloors()->current();
            $overlayFloors->addContent(
                    Xhtml::div( $floor->getName() )->class_( $floorMain->getId() == $floor->getId() ? "selected" : "" )->attr(
                            "data-floor", $floor->getId() ) );
        }
        $overlayWrapper->addContent( $overlayFloors );

        $wrapper->addContent( $canvas );
        $wrapper->addContent( $loaderWrapper );
        $wrapper->addContent( $overlayWrapper );
        $root->addContent( $wrapper );
    }

    // ... /DRAW


    // /FUNCTIONS


}

?>