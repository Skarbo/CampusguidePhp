<?php

class BuildingcreatorBuildingsCmsPageMainView extends PageCmsPageMainView implements BuildingcreatorBuildingsCmsInterfaceView
{

    // VARIABLES


    private static $ID_BUILDINGCREATOR_WRAPPER = "buildingcreator_page_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_WRAPPER = "buildingcreator_menu_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_LEFT_WRAPPER = "buildingcreator_menu_left_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_RIGHT_WRAPPER = "buildingcreator_menu_right_wrapper";
    private static $ID_CREATOR_WRAPPER = "buildingcreator_planner_wrapper";
    private static $ID_CREATOR_SIDEBAR_WRAPPER = "buildingcreator_planner_sidebar_wrapper";
    private static $ID_CREATOR_SIDEBAR_SIDEBARS = "sidebars";
    private static $ID_CREATOR_SIDEBAR_INFOPANEL = "infopanel";
    private static $ID_CREATOR_CONTENT_WRAPPER = "buildingcreator_planner_content_wrapper";
    private static $ID_CREATOR_CONTENT_TOOLBAR_WRAPPER = "buildingcreator_planner_content_toolbar_wrapper";

    private static $ID_CREATOR_CONTENT_CANVAS_WRAPPER = "buildingcreator_planner_content_canvas_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_CONTENT_WRAPPER = "buildingcreator_planner_content_canvas_content_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_LOADER_WRAPPER = "buildingcreator_planner_content_canvas_loader_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_LOADER_STATUS_WRAPPER = "buildingcreator_planner_content_canvas_loader_status_wrapper";

    /**
     * @var RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView
     */
    private $roomsElementsSidebarPresenter;
    /**
     * @var DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView
     */
    private $devicesElementsSidebarPresenter;
    /**
     * @var FloorsSidebarBuildingcreatorBuildingsCmsPresenterView
     */
    private $floorsSidebarPresenter;
    /**
     * @var MenuBuildingcreatorBuildingsCmsPresenterView
     */
    private $menuPresenter;
    /**
     * @var ToolbarBuildingcreatorBuildingsCmsPresenterView
     */
    private $toolbarPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );

        $this->roomsElementsSidebarPresenter = new RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView( $this );
        $this->devicesElementsSidebarPresenter = new DevicesElementsSidebarBuildingcreatorBuildingsCmsPresenterView(
                $this );
        $this->floorsSidebarPresenter = new FloorsSidebarBuildingcreatorBuildingsCmsPresenterView( $this );
        $this->menuPresenter = new MenuBuildingcreatorBuildingsCmsPresenterView( $this );
        $this->toolbarPresenter = new ToolbarBuildingcreatorBuildingsCmsPresenterView( $this );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPageMainView::getController()
     * @return BuildingsCmsMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see AbstractPageMainView::getView()
     * @return BuildingsCmsMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuilding()
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
     * @see PageCmsPageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_BUILDINGCREATOR_WRAPPER;
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageCmsPageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {

        $table = Xhtml::div( Xhtml::div( Xhtml::h( 2, "Building Creator" ) ) )->addClass( Resource::css()->getTable() );
        //         $table->addContent(
        //                 Xhtml::div(
        //                         Xhtml::div(
        //                                 Xhtml::div( "Maxmimize" )->class_( Resource::css()->gui()->getComponent() )->attr(
        //                                         "data-type", "toggle" )->id( "maximize" ) )->class_(
        //                                 Resource::css()->gui()->getGui(), "theme2" ) )->class_( Resource::css()->getRight() )->style(
        //                         "font-size: 0.7em;" ) );
        $table->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::input()->type( InputXhtml::$TYPE_CHECKBOX )->autocomplete( false )->id(
                                        "page_maximize" ) )->addContent(
                                Xhtml::label( "Maximize" )->for_( "page_maximize" ) ) )->class_(
                        Resource::css()->getRight() ) );
        $root->addContent( $table );

    }

    /**
     * @see PageCmsPageMainView::drawBody()
     */
    protected function drawBody( AbstractXhtml $root )
    {

        // Draw menu to wrapper
        //         $this->drawMenu( $root );
        $this->menuPresenter->draw( $root );

        // Draw planner to wrapper
        $this->drawPlanner( $root );

    }

    //     /**
    //      * @see AbstractPageMainView::draw()
    //      */
    //     public function draw( AbstractXhtml $root )
    //     {


    //         if ( $this->getView()->getController()->getErrors() )
    //         {
    //             return;
    //         }


    //         // Create page wrapper
    //         $pageWrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_WRAPPER );


    //         // Add header to wrapper
    //         $table = Xhtml::div( Xhtml::div( Xhtml::h( 2, "Building Creator" ) ) )->addClass(
    //                 Resource::css()->getTable() );
    //         $table->addContent(
    //                 Xhtml::div(
    //                         Xhtml::div(
    //                                 Xhtml::div( "Maxmimize" )->class_( Resource::css()->gui()->getComponent() )->attr(
    //                                         "data-type", "toggle" )->id( "maximize" ) )->class_(
    //                                 Resource::css()->gui()->getGui(), "theme2" ) )->class_( Resource::css()->getRight() )->style(
    //                         "font-size: 0.7em;" ) );
    //         $pageWrapper->addContent( $table );


    //         // Building Buildings Presenter
    //         $buildingBuildingsPresenter = new BuildingBuildingsCmsPresenterView( $this );
    //         $buildingBuildingsPresenter->setFacility( $this->getFacility() );
    //         $buildingBuildingsPresenter->setBuilding( $this->getBuilding() );
    //         $buildingBuildingsPresenter->draw( $pageWrapper );


    //         // Draw menu to wrapper
    //         $this->drawMenu( $pageWrapper );


    //         // Draw planner to wrapper
    //         $this->drawPlanner( $pageWrapper );


    //         // Add page wrapper to root
    //         $root->addContent( $pageWrapper );


    //     }


    // ... ... CREATOR


    /**
     * @param AbstractXhtml $root
     */
    private function drawPlanner( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_CREATOR_WRAPPER );

        // Create table
        $table = Xhtml::div()->addClass( Resource::css()->getTable() );

        // Draw planner sidebar
        $left = Xhtml::div();
        $this->drawPlannerSidebar( $left );
        $table->addContent( $left );

        // Draw planner content
        $right = Xhtml::div();
        $this->drawPlannerContent( $right );
        $table->addContent( $right );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml header
     */
    private function drawPlannerSidebar( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_CREATOR_SIDEBAR_WRAPPER );

        $sidebarWrapper = Xhtml::div()->id( self::$ID_CREATOR_SIDEBAR_SIDEBARS );
        $sidebarInfoPanelWrapper = Xhtml::div()->id( self::$ID_CREATOR_SIDEBAR_INFOPANEL );

        // INFO PANEL HEADER


        $sidebarInfoPanelheaderWrapper = Xhtml::div()->id( "infopanel_header_wrapper" );
        $sidebarInfoPanelheaderTable = Xhtml::div()->class_( Resource::css()->getTable() );
        $sidebarInfoPanelheaderTable->addContent( Xhtml::div( "Header" )->class_( "infopanel_header_name" ) );
        $sidebarInfoPanelButtons = Xhtml::div()->class_( Resource::css()->getRight(), "infopanel_header_buttons" );
        $sidebarInfoPanelButtons->addContent( Xhtml::button( "Cancel" )->id( "infopanel_header_buttons_cancel" ) );
        $sidebarInfoPanelButtons->addContent(
                Xhtml::button( "Save" )->id( "infopanel_header_buttons_save" )->class_( "invert" ) );
        $sidebarInfoPanelButtons->addContent(
                Xhtml::button( "Save & goto next" )->id( "infopanel_header_buttons_save_next" ) );
        $sidebarInfoPanelheaderTable->addContent( $sidebarInfoPanelButtons );
        $sidebarInfoPanelheaderWrapper->addContent( $sidebarInfoPanelheaderTable );
        $sidebarInfoPanelWrapper->addContent( $sidebarInfoPanelheaderWrapper );

        // /INFO PANEL HEADER


        // Floors
        $this->floorsSidebarPresenter->draw( $sidebarWrapper );
        $this->floorsSidebarPresenter->addInfoPanelContent( "element_name", "element", "Name",
                ElementsSidebarBuildingcreatorBuildingsCmsPresenterView::drawInfoPanelName() );
        $this->floorsSidebarPresenter->drawInfoPanelContent( $sidebarInfoPanelWrapper );

        // Rooms Elements
        $this->roomsElementsSidebarPresenter->draw( $sidebarWrapper );
        $this->roomsElementsSidebarPresenter->drawInfoPanelContent( $sidebarInfoPanelWrapper );

        // Devices Elements
        $this->devicesElementsSidebarPresenter->draw( $sidebarWrapper );
        $this->devicesElementsSidebarPresenter->drawInfoPanelContent( $sidebarInfoPanelWrapper );

        $wrapper->addContent( $sidebarInfoPanelWrapper );
        $wrapper->addContent( $sidebarWrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawPlannerContent( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_CREATOR_CONTENT_WRAPPER );

        // Draw planner toolbar
        $this->toolbarPresenter->draw( $wrapper );

        // Create canvas wrapper
        $canvasWrapper = Xhtml::div()->id( self::$ID_CREATOR_CONTENT_CANVAS_WRAPPER );

        // ... Canvas content
        $canvasWrapper->addContent( Xhtml::div()->id( self::$ID_CREATOR_CONTENT_CANVAS_CONTENT_WRAPPER ) );

        // Add loader to wrapper
        $canvasWrapper->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( Xhtml::div( "Loading building" )->class_( "loading_building" ) )->addContent(
                                        Xhtml::div( "Loading floors" )->class_( "loading_floors" ) )->addContent(
                                        Xhtml::div( "Loading elements" )->class_( "loading_elements" ) )->addContent(
                                        Xhtml::div( "Loading navigation" )->class_( "loading_navigation" ) )->addContent(
                                        Xhtml::div( "Saving..." )->class_( "saving" ) )->id(
                                        self::$ID_CREATOR_CONTENT_CANVAS_LOADER_STATUS_WRAPPER ) )->addContent(
                                Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading" ) )->class_(
                                Resource::css()->getMiddle() ) )->id( self::$ID_CREATOR_CONTENT_CANVAS_LOADER_WRAPPER )->class_(
                        Resource::css()->getTable() ) );

        // Add canvas wrapper to wrapper
        $wrapper->addContent( $canvasWrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /CREATOR


    // ... /DRAW


    // /FUNCTIONS


}

?>