<?php

class ViewBuildingBuildingsCmsPageMainView extends PageCmsPageMainView implements BuildingBuildingsCmsInterfaceView
{

    // VARIABLES


    private static $ID_WRAPPER = "view_building_buildings_wrapper";
    private static $ID_CANVAS_WRAPPER = "canvas_wrapper";
    private static $ID_CANVAS_CONTENT_WRAPPER = "canvas_content_wrapper";
    private static $ID_CANVAS_LOADER_STATUS_WRAPPER = "canvas_loader_status_wrapper";
    private static $ID_CANVAS_LOADER_WRAPPER = "canvas_loader_wrapper";
    private static $ID_TOOLBAR_WRAPPER = "toolbar_wrapper";
    private static $ID_FLOOR_PICKER_WRAPPER = "floor_picker_wrapper";
    private static $ID_FLOOR_PICKER_CONTENT = "floor_picker_content";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    protected function getWrapperId()
    {
        return self::$ID_WRAPPER;
    }

    /**
     * @see AbstractPageMainView::getController()
     * @return BuildingsCmsMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see BuildingBuildingsCmsInterfaceView::getFacility()
     */
    public function getFacility()
    {
        return $this->getController()->getFacility();
    }

    /**
     * @see BuildingsCmsInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getController()->getBuilding();
    }

    /**
     * @see BuildingBuildingsCmsInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getController()->getBuildingFloors();
    }

    // ... /GET


    // ... DRAW


    protected function drawHeader( AbstractXhtml $root )
    {

        // Create header table
        $headerTable = Xhtml::div()->class_( Resource::css()->getTable() );

        // Add header to header table
        $headerTable->addContent( Xhtml::div( Xhtml::h( 2, "Building" ) ) );

        // Draw sub menu
        $headerTableCell = Xhtml::div()->class_( Resource::css()->getTableCell(), Resource::css()->getRight() );

        // Buttons gui
        $buttonsGui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui(), "theme2" );

        // Delete button
        $buttonsGui->addContent(
                Xhtml::a( "Delete" )->href(
                        Resource::url()->cms()->buildings()->getDeleteBuildingPage( $this->getBuilding()->getId(),
                                $this->getMode() ) )->title( "Delete" )->addClass( Resource::css()->gui()->getComponent() ) );

        $headerTableCell->addContent( $buttonsGui );

        $headerTable->addContent( $headerTableCell );

        $root->addContent( $headerTable );

    }

    protected function drawBody( AbstractXhtml $root )
    {

        // Building Buildings Presenter
        $buildingBuildingsPresenter = new BuildingBuildingsCmsPresenterView( $this );
        $buildingBuildingsPresenter->setFacility( $this->getFacility() );
        $buildingBuildingsPresenter->setBuilding( $this->getBuilding() );
        $buildingBuildingsPresenter->draw( $root );

        // Building Canvas
        $this->drawBuildingCanvas( $root );

    }

    private function drawBuildingCanvas( AbstractXhtml $root )
    {

        // TOOLBAR


        $toolbarWrapper = Xhtml::div()->id( self::$ID_TOOLBAR_WRAPPER );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( "-" )->id( "scale_dec" )->attr( "data-disabled", "true" )->addClass(
                        Resource::css()->gui()->getComponent() ) );
        $gui->addContent(
                Xhtml::a( "+" )->id( "scale_inc" )->attr( "data-disabled", "true" )->addClass(
                        Resource::css()->gui()->getComponent() ) );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "layer_max" ) )->id( "layer_fit" )->addClass(
                        Resource::css()->gui()->getComponent() )->attr( "data-disabled", "true" )->title( "Fit to stage" ) );

        $toolbarWrapper->addContent( $gui );

        $root->addContent( $toolbarWrapper );

        // /TOOLBAR


        // CANVAS


        // Create canvas wrapper
        $canvasWrapper = Xhtml::div()->id( self::$ID_CANVAS_WRAPPER );

        // ... FLOOR PICKER


        $floorPickerWrapper = Xhtml::div()->id( self::$ID_FLOOR_PICKER_WRAPPER );
        $floorPickerContent = Xhtml::div()->id( self::$ID_FLOOR_PICKER_CONTENT );

        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();
            $floorPickerContent->addContent(
                    Xhtml::div( $floor->getName() )->title( $floor->getName() )->attr( "data-floor", $floor->getId() )->attr(
                            "data-floor-main", $floor->getMain() )->class_( "floor_pick_wrapper" ) );
        }

        $floorPickerWrapper->addContent( $floorPickerContent );
        $canvasWrapper->addContent( $floorPickerWrapper );

        // ... /FLOOR PICKER


        // ... Canvas content
        $canvasWrapper->addContent( Xhtml::div()->id( self::$ID_CANVAS_CONTENT_WRAPPER ) );

        // ... Canvas loader
        $canvasWrapper->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( Xhtml::div( "Loading building" )->class_( "loading_building" ) )->addContent(
                                        Xhtml::div( "Loading floors" )->class_( "loading_floors" ) )->addContent(
                                        Xhtml::div( "Loading elements" )->class_( "loading_elements" ) )->id(
                                        self::$ID_CANVAS_LOADER_STATUS_WRAPPER ) )->addContent(
                                Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading" ) )->class_(
                                Resource::css()->getMiddle() ) )->id( self::$ID_CANVAS_LOADER_WRAPPER )->class_(
                        Resource::css()->getTable() ) );

        $root->addContent( $canvasWrapper );

        // /CANVAS
    }

    // ... /DRAW


    // /FUNCTIONS


}

?>