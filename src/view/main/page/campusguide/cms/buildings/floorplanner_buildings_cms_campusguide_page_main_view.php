<?php

class FloorplannerBuildingsCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    private static $ID_FLORPLANNER_WRAPPER = "floorplanner_page_wrapper";
    private static $ID_FLOORPLANNER_MENU_WRAPPER = "floorplanner_menu_wrapper";
    private static $ID_FLOORPLANNER_MENU_LEFT_WRAPPER = "floorplanner_menu_left_wrapper";
    private static $ID_FLOORPLANNER_MENU_RIGHT_WRAPPER = "floorplanner_menu_right_wrapper";
    private static $ID_PLANNER_WRAPPER = "floorplanner_planner_wrapper";
    private static $ID_PLANNER_SIDEBAR_WRAPPER = "floorplanner_planner_sidebar_wrapper";
    private static $ID_PLANNER_CONTENT_WRAPPER = "floorplanner_planner_content_wrapper";
    private static $ID_PLANNER_CONTENT_TOOLBAR_WRAPPER = "floorplanner_planner_content_toolbar_wrapper";
    private static $ID_PLANNER_CONTENT_CANVAS_WRAPPER = "floorplanner_planner_content_canvas_wrapper";

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

    // ... /GET


    // ... DRAW


    /**
     * @see PageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_FLORPLANNER_WRAPPER );

        // Add header to wrapper
        $pageWrapper->addContent( Xhtml::h( 2, "Floor Planner" ) );

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
        $wrapper = Xhtml::div()->id( self::$ID_FLOORPLANNER_MENU_WRAPPER );

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
        $wrapper = Xhtml::div()->id( self::$ID_FLOORPLANNER_MENU_LEFT_WRAPPER );

        // Create GUI
        $gui = Xhtml::div()->class_( Resource::css()->gui()->getGui() );

        $gui->addContent(
                Xhtml::div( "Building" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-menu",
                        "building" ) );
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
        $wrapper = Xhtml::div()->id( self::$ID_FLOORPLANNER_MENU_RIGHT_WRAPPER );

        // Create table
        $gui = Xhtml::div()->class_( Resource::css()->gui()->getGui() );

        $gui->addContent( Xhtml::a( "Cancel" )->addClass( Resource::css()->gui()->getComponent() ) );
        $gui->addContent( Xhtml::a( "Save" )->addClass( Resource::css()->gui()->getComponent() ) );

        // Add GUI to wrapper
        $wrapper->addContent( $gui );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /MENU


    // ... ... PLANNER


    /**
     * @param AbstractXhtml $root
     */
    private function drawPlanner( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_PLANNER_WRAPPER );

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
        $wrapper = Xhtml::div()->id( self::$ID_PLANNER_SIDEBAR_WRAPPER );

        // Create sidebar


        // ... Building


        // ... ... Floors
        $sidebar = Xhtml::div()->class_( "sidebar" )->attr( "data-sidebar", "floors" )->attr(
                "data-sidebar-group", "building" );

        $header = Xhtml::div()->class_( Resource::css()->getTable(), "sidebar_header_wrapper" );
        $header->addContent( Xhtml::h( 1, "Floors" ) );
        $header->addContent( Xhtml::span( "0" ) );

        $content = Xhtml::div()->class_( "content" );
        $content->addContent( "Content" );

        $sidebar->addContent( $header );
        $sidebar->addContent( $content );

        $wrapper->addContent( $sidebar );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawPlannerContent( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_PLANNER_CONTENT_WRAPPER );

        // Draw planner toolbar
        $this->drawPlannerToolbar( $wrapper );

        // Add canvas wrapper to wrapper
        $wrapper->addContent( Xhtml::div()->id( self::$ID_PLANNER_CONTENT_CANVAS_WRAPPER ) );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawPlannerToolbar( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_PLANNER_CONTENT_TOOLBAR_WRAPPER );

        // Create table
        $table = Xhtml::div()->addClass( Resource::css()->getTable() );

        // ... Left
        $left = Xhtml::div();

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent( Xhtml::a( "-" )->id( "scale_dec" )->addClass( Resource::css()->gui()->getComponent() ) );
        $gui->addContent( Xhtml::a( "+" )->id( "scale_inc" )->addClass( Resource::css()->gui()->getComponent() ) );

        $left->addContent( $gui );

        $table->addContent( $left );

        // ... Center
        $center = Xhtml::div()->addClass( Resource::css()->getCenter() );

        $table->addContent( $center );

        // ... Right
        $right = Xhtml::div()->addClass( Resource::css()->getRight() );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent( Xhtml::a( "Redo" )->addClass( Resource::css()->gui()->getComponent() ) );
        $gui->addContent( Xhtml::a( "Undo" )->addClass( Resource::css()->gui()->getComponent() ) );

        $right->addContent( $gui );

        $table->addContent( $right );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /PLANNER


    // ... /DRAW


    // /FUNCTIONS


}

?>