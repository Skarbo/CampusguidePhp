<?php

class BuildingcreatorBuildingsCmsPageMainView extends AbstractPageMainView implements BuildingcreatorBuildingsCmsInterfaceView
{

    // VARIABLES


    private static $ID_BUILDINGCREATOR_WRAPPER = "buildingcreator_page_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_WRAPPER = "buildingcreator_menu_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_LEFT_WRAPPER = "buildingcreator_menu_left_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_RIGHT_WRAPPER = "buildingcreator_menu_right_wrapper";
    private static $ID_CREATOR_WRAPPER = "buildingcreator_planner_wrapper";
    private static $ID_CREATOR_SIDEBAR_WRAPPER = "buildingcreator_planner_sidebar_wrapper";
    private static $ID_CREATOR_CONTENT_WRAPPER = "buildingcreator_planner_content_wrapper";
    private static $ID_CREATOR_CONTENT_TOOLBAR_WRAPPER = "buildingcreator_planner_content_toolbar_wrapper";

    private static $ID_CREATOR_CONTENT_CANVAS_WRAPPER = "buildingcreator_planner_content_canvas_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_CONTENT_WRAPPER = "buildingcreator_planner_content_canvas_content_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_LOADER_WRAPPER = "buildingcreator_planner_content_canvas_loader_wrapper";
    private static $ID_CREATOR_CONTENT_CANVAS_LOADER_STATUS_WRAPPER = "buildingcreator_planner_content_canvas_loader_status_wrapper";

    /**
     * @var ElementsSidebarBuildingcreatorBuildingsCmsPresenterView
     */
    private $elementsSidebarPresenter;
    /**
     * @var RoomsSidebarBuildingcreatorBuildingsCmsPresenterView
     */
    private $floorsSidebarPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );

        $this->elementsSidebarPresenter = new ElementsSidebarBuildingcreatorBuildingsCmsPresenterView( $this );
        $this->floorsSidebarPresenter = new FloorsSidebarBuildingcreatorBuildingsCmsPresenterView( $this );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


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
        return $this->getView()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getView()->getBuildingFloors();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->getView()->getBuildingElements();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AbstractPageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        if ( $this->getView()->getController()->getErrors() )
        {
            return;
        }

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_WRAPPER );

        // Add header to wrapper
        $table = Xhtml::div( Xhtml::div( Xhtml::h( 2, "Building Creator" ) ) )->addClass(
                Resource::css()->getTable() );
        $table->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( "Maxmimize" )->class_( Resource::css()->gui()->getComponent() )->attr(
                                        "data-type", "toggle" )->id( "maximize" ) )->class_(
                                Resource::css()->gui()->getGui(), "theme2" ) )->class_( Resource::css()->getRight() )->style(
                        "font-size: 0.7em;" ) );
        $pageWrapper->addContent( $table );

        // Draw menu to wrapper
        $this->drawMenu( $pageWrapper );

        // Draw planner to wrapper
        $this->drawPlanner( $pageWrapper );

        // Add page wrapper to root
        $root->addContent( $pageWrapper );

    }

    // ... ... MENU


    /**
     * @param AbstractXhtml $root
     */
    private function drawMenu( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_MENU_WRAPPER );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // Draw sub menu on table
        $left = Xhtml::div();
        $this->drawMenuLeft( $left );
        $table->addContent( $left );

        // Create right menu
        $right = Xhtml::div()->class_( Resource::css()->getRight() );
        $this->drawMenuRight( $right );
        $table->addContent( $right );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawMenuLeft( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_MENU_LEFT_WRAPPER );

        // Create GUI
        $gui = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );

        $gui->addContent(
                Xhtml::div( "Floors" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-menu",
                        "floors" ) );
        $gui->addContent(
                Xhtml::div( "Elements" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-menu",
                        "elements" ) );
        $gui->addContent(
                Xhtml::div( "Navigation" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-menu",
                        "navigation" ) );

        // Add gui to wrapper
        $wrapper->addContent( $gui );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawMenuRight( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_MENU_RIGHT_WRAPPER );

        // Create table
        $gui = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );

        $gui->addContent(
                Xhtml::a( "Cancel" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-disabled",
                        "true" ) );
        $gui->addContent(
                Xhtml::a( "Save" )->addClass( Resource::css()->gui()->getComponent() )->id( "save" )->attr(
                        "data-disabled", "true" ) );

        // Add GUI to wrapper
        $wrapper->addContent( $gui );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /MENU


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

        // Rooms
        $this->floorsSidebarPresenter->draw( $wrapper );

        // Elements
        $this->elementsSidebarPresenter->draw( $wrapper );

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
        $this->drawPlannerToolbar( $wrapper );

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

    /**
     * @param AbstractXhtml $root
     */
    private function drawPlannerToolbar( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_CREATOR_CONTENT_TOOLBAR_WRAPPER );

        // Create table
        $table = Xhtml::div()->addClass( Resource::css()->getTable() );

        // ... Left
        $left = Xhtml::div();

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

        $left->addContent( $gui );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "map" ) )->id( "toggle_map" )->attr( "data-type", "toggle" )->attr(
                        "data-disabled", "true" )->addClass( Resource::css()->gui()->getComponent(), "checked" )->title(
                        "Toggle map" ) );

        $left->addContent( $gui );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "polygon" ) )->addClass(
                        Resource::css()->gui()->getComponent() )->title( "Polygon" )->id( "polygon" ) );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "polygon_straight" ) )->attr( "data-type", "radio" )->attr(
                        "data-name", "line_type" )->attr( "data-line", "straight" )->attr( "data-disabled", "true" )->addClass(
                        "line_type", Resource::css()->gui()->getComponent() )->title( "Straight" ) );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "polygon_quad" ) )->attr( "data-type", "radio" )->attr(
                        "data-name", "line_type" )->attr( "data-line", "quad" )->attr( "data-disabled", "true" )->addClass(
                        "line_type", Resource::css()->gui()->getComponent() )->title( "Quadratic" ) );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "polygon_bezier" ) )->attr( "data-type", "radio" )->attr(
                        "data-name", "line_type" )->attr( "data-line", "bezier" )->attr( "data-disabled", "true" )->addClass(
                        "line_type", Resource::css()->gui()->getComponent() )->title( "Bezier" ) );

        $left->addContent( $gui );

        $table->addContent( $left );

        // ... Center
        $center = Xhtml::div()->addClass( Resource::css()->getCenter() );

        $table->addContent( $center );

        // ... Right
        $right = Xhtml::div()->addClass( Resource::css()->getRight() );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "copy" ) )->addClass(
                        Resource::css()->gui()->getComponent() )->id( "copy" )->title( "Copy/paste" )->attr(
                        "data-disabled", "true" ) );
        $gui->addContent(
                Xhtml::a( Xhtml::div()->attr( "data-icon", "trashbin" ) )->addClass(
                        Resource::css()->gui()->getComponent() )->id( "delete" )->title( "Delete" )->attr(
                        "data-disabled", "true" ) );

        $right->addContent( $gui );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( "Undo" )->id( "undo" )->attr( "data-disabled", "true" )->addClass(
                        Resource::css()->gui()->getComponent() ) );

        $right->addContent( $gui );

        $table->addContent( $right );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /CREATOR


    // ... /DRAW


    // /FUNCTIONS


}

?>