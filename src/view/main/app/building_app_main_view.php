<?php

class BuildingAppMainView extends AppMainView implements BuildingAppInterfaceView
{

    // VARIABLES


    private static $ID_BUILDING_PAGE_WRAPPER = "building_page_wrapper";
    private static $ID_BUILDING_CANVAS_WRAPPER = "building_canvas_wrapper";
    private static $ID_BUILDING_CANVAS = "building_canvas";
    private static $ID_BUILDING_LOADER_WRAPPER = "building_loader";
    private static $ID_BUILDING_CANVAS_OVERLAY_WRAPPER = "building_canvas_overlay_wrapper";
    private static $ID_BUILDING_CANVAS_OVERLAY_FLOORS = "building_canvas_overlay_floors";
    private static $ID_BUILDING_CANVAS_OVERLAY_ZOOM = "building_canvas_overlay_zoom";
    private static $ID_BUILDING_CANVAS_OVERLAY_ELEMENTS = "building_canvas_overlay_elements";

    /**
     * @var OverlayAppPresenterView
     */
    private $overlayPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppMainView::getController()
     * @return BuildingAppMainController
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

    /**
     * @see BuildingAppInterfaceView::getElements()
     */
    public function getElements()
    {
        return $this->getController()->getElements();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AppMainView::drawPage()
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
     * @see AppMainView::drawMenu()
     */
    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {
        $this->getActionbarPresenter()->setIcon( Xhtml::div()->attr( "data-icon", "home" ) );
        $this->getActionbarPresenter()->setBackReferer( Resource::url()->app()->getMap( $this->getMode() ) );

        $this->getActionbarPresenter()->addViewControl(
                Xhtml::div( Xhtml::div( $this->getBuilding()->getName() ) )->addContent(
                        Xhtml::div( $this->getFacility()->getName() ) )->class_( "double" ) );

        // Search
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div()->attr( "data-icon", "search" )->title( "Search" )->class_( "actionbar_menu_search" ) );

        // Location
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "location" )->title( "Location" )->class_( "menu_button_location" ) );

        // More
        $this->getActionbarPresenter()->addActionButton(
                Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_( "menu_button_more" ) );

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
        $wrapper->addContent( $canvas );

        // Loader wrapper
        $loaderWrapper = Xhtml::div()->id( self::$ID_BUILDING_LOADER_WRAPPER )->class_(
                Resource::css()->getTable() );
        $loaderWrapper->addContent(
                Xhtml::div( Xhtml::div( "Loading..." ) )->addContent(
                        Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading" ) )->class_(
                        Resource::css()->getMiddle() ) );
        $wrapper->addContent( $loaderWrapper );

        // FLOORS OVERLAY
        $overlayFloors = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_OVERLAY_FLOORS );

        $floorMain = $this->getController()->getFloors()->getMainFloor();
        for ( $i = $this->getController()->getFloors()->size() - 1; $i >= 0; $i-- )
        //         for ( $this->getController()->getFloors()->rewind(); $this->getController()->getFloors()->valid(); $this->getController()->getFloors()->next() )
        {
            $floor = $this->getController()->getFloors()->get( $i );
            $overlayFloors->addContent(
                    Xhtml::div( $floor->getName() )->class_( $floorMain->getId() == $floor->getId() ? "selected" : "" )->attr(
                            "data-floor", $floor->getId() ) );
        }
        $wrapper->addContent( $overlayFloors );

        // /FLOORS OVERLAY


        // ZOOM OVERLAY


        $overlayZoom = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_OVERLAY_ZOOM );

        $overlayZoom->addContent(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getPlusSvg( "#939393", "#939393" ) ) )->attr(
                        "data-zoom-in", "true" ) );
        $overlayZoom->addContent(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getMinusSvg( "#939393", "#939393" ) ) )->attr(
                        "data-zoom-in", "false" ) );
        $wrapper->addContent( $overlayZoom );

        // /ZOOM OVERLAY


        // Elements overlay
        $this->drawElementOverlays( $wrapper );

        $root->addContent( $wrapper );
    }

    private function drawElementOverlays( AbstractXhtml $root )
    {

        $elementsOverlay = Xhtml::div()->id( self::$ID_BUILDING_CANVAS_OVERLAY_ELEMENTS );

        // Foreach Elements
        for ( $this->getElements()->rewind(); $this->getElements()->valid(); $this->getElements()->next() )
        {
            $element = $this->getElements()->current();
            $this->drawElementOverlay( $elementsOverlay, $element );
        }

        $root->addContent( $elementsOverlay );

    }

    private function drawElementOverlay( AbstractXhtml $root, ElementBuildingModel $element )
    {

        $overlayElement = Xhtml::div()->class_( "overlay_element" )->attr( "data-element", $element->getId() );

        // Direction
        $overlayElement->addContent(
                Xhtml::div( Xhtml::span()->attr( "data-icon", "direction" ) )->class_( "direction" ) );
        $overlayElement->addContent(
                Xhtml::div( Xhtml::img( Resource::image()->getEmptyImage() ) )->class_( "border" ) );

        // Element image
        $elementImage = Resource::image()->building()->element()->getType( $element->getType() );
        if ( $elementImage )
        {
            $overlayElement->addContent(
                    Xhtml::div(
                            Xhtml::img( $elementImage )->title(
                                    $this->getLocale()->building()->element()->getType( $element->getType() ) ) )->class_(
                            "element_image" ) );
            $overlayElement->addContent(
                    Xhtml::div( Xhtml::img( Resource::image()->getEmptyImage() ) )->class_( "border" ) );
        }

        // Element
        $overlayElement->addContent(
                Xhtml::div( $element->getName() )->addContent( Xhtml::span()->attr( "data-icon", "right" ) )->class_(
                        "element" ) );

        // Pointer
        $overlayElement->addContent(
                Xhtml::div( Xhtml::div( Xhtml::$NBSP )->class_( "pointer" ) )->class_( "pointer_wrapper" ) );

        $root->addContent( $overlayElement );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>