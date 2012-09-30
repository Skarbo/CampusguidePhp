<?php

class BuildingAppCampusguideMainView extends AppCampusguideMainView implements BuildingAppCampusguideInterfaceView
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

    public function getBuilding()
    {
        return $this->getController()->getBuilding();
    }

    public function getFacility()
    {
        return $this->getController()->getFacility();
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

    /**
     * @see AppCampusguideMainView::drawMenu()
     */
    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {
        $this->getActionbarPresenter()->setIcon( Xhtml::div()->attr( "data-icon", "home" ) );
        $this->getActionbarPresenter()->setBackReferer(
                Resource::url()->campusguide()->app()->getMap( $this->getMode() ) );

        $this->getActionbarPresenter()->addViewControl(
                Xhtml::div( Xhtml::div( $this->getBuilding()->getName() ) )->addContent(
                        Xhtml::div( $this->getFacility()->getName() ) )->class_( "double" ) );

        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div()->attr( "data-icon", "search" )->title( "Search" )->class_( "actionbar_menu_search" ) );

        $this->getActionbarPresenter()->draw( $rootTop );
        $this->getActionbarPresenter()->drawBottom( $rootBottom );
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