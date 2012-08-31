<?php

class BuildingcreatorBuildingsCmsCampusguidePageMainView extends PageMainView implements BuildingcreatorBuildingsCmsCampusguideInterfaceView
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

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PageMainView::getView()
     * @return BuildingsCmsCampusguideMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see BuildingcreatorBuildingsCmsCampusguideInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getView()->getController()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsCampusguideInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getView()->getController()->getBuildingFloors();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageMainView::draw()
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
        $pageWrapper->addContent( Xhtml::h( 2, "Building Creator" ) );

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
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGCREATOR_MENU_RIGHT_WRAPPER );

        // Create table
        $gui = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );

        $gui->addContent( Xhtml::a( "Cancel" )->addClass( Resource::css()->gui()->getComponent() ) );
        $gui->addContent( Xhtml::a( "Save" )->addClass( Resource::css()->gui()->getComponent() ) );

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

        // Create sidebar


        // ... Building


        // ... ... Floors
        $sidebar = Xhtml::div()->class_( "sidebar" )->attr( "data-sidebar", "floors" )->attr(
                "data-sidebar-group", "building" );

        $header = Xhtml::div()->class_( Resource::css()->getTable(), "sidebar_header_wrapper" );
        $header->addContent( Xhtml::h( 1, "Floors" ) );
        $header->addContent( Xhtml::span( $this->getBuildingFloors()->size() ) );

        // ... ... ... Content
        $content = Xhtml::div()->class_( "content" );

        $floorForm = Xhtml::form()->method( FormXhtml::$METHOD_POST )->action( "?" )->autocomplete( false )->id("floors_form");

        $floorTable = Xhtml::div()->class_( Resource::css()->getTable(), "floors" );

        // For each floors
        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();

            // Create floors row
            $floorRow = self::createFloorsRow($floor);

            /*
            $floorRow = Xhtml::div()->class_( Resource::css()->getTableRow(), "floor" )->attr( "data-floor",
                    $floor->getId() );

            // Floor name
            $floorRow->addContent( Xhtml::div( $floor->getName() )->class_( "name" ) );
            $floorRow->addContent(
                    Xhtml::div(
                            Xhtml::input( $floor->getName(), sprintf( "floor_name[%s]", $floor->getId() ) )->attr(
                                    "data-hint", "Name" ) )->class_( "name_edit" ) );

            // Floor map
            $floorRow->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::div( Xhtml::div()->attr( "data-icon", "map" ) )->attr( "data-type", "file" )->class_(
                                            Resource::css()->gui()->getComponent() ) )->class_(
                                    Resource::css()->gui()->getGui() ) )->title( "Map" )->class_( "map_edit" ) );

            // Floor order
            $floorRow->addContent(
                    Xhtml::div( Xhtml::div()->attr( "data-icon", "up" )->class_( "up" )->title( "Order up" ) )->addContent(
                            Xhtml::div()->attr( "data-icon", "down" )->class_( "down" )->title( "Order down" ) )->addContent(
                            Xhtml::input( $floor->getOrder(), sprintf( "floor_order[%s]", $floor->getId() ) ) )->class_(
                            Resource::css()->getRight(), "order_edit" ) );

            // Floor main
            $floorRow->addContent(
                    Xhtml::div( $floor->getMain() ? Xhtml::div()->attr( "data-icon", "star" ) : "" )->class_(
                            Resource::css()->getRight(), "main" ) );
            $floorRow->addContent(
                    Xhtml::div(
                            Xhtml::div(
                                    Xhtml::div( Xhtml::div()->attr( "data-icon", "star" ) )->attr( "data-type",
                                            "radio" )->attr( "data-radio-name", "floor_main" )->attr( "data-value",
                                            $floor->getId() )->class_( Resource::css()->gui()->getComponent(),
                                            $floor->getMain() ? "checked" : "" ) )->class_(
                                    Resource::css()->gui()->getGui() ) )->class_( Resource::css()->getRight(), "main_edit" ) );
*/
            $floorTable->addContent( $floorRow );
        }

        // No floors
        if ( $this->getBuildingFloors()->isEmpty() )
        {
            $floorTable->addContent( Xhtml::div( Xhtml::italic( "No floors" ) ) );
        }

        // New floor
        $floorOrderNext = $this->getBuildingFloors()->getNextOrder();
        $floorNew = FloorBuildingFactoryModel::createFloorBuilding(0, "", $floorOrderNext, array());
        $floorNew->setId("new");
        $floorNewRow = self::createFloorsRow($floorNew);
        $floorNewRow->addClass("new");
        $floorTable->addContent( $floorNewRow );

        // Floors error
        $floorsError = Xhtml::div()->class_(Resource::css()->campusguide()->cms()->getError())->id("floors_error");

        // Floor buttons
        $floorButtons = Xhtml::div()->class_( "floor_buttons", Resource::css()->gui()->getGui(), "theme4" );
        $floorButtons->addContent(
                Xhtml::div( "Cancel" )->id( "floors_cancel" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->gui()->getButton() )->attr( "data-disabled", "true" ) );
        $floorButtons->addContent(
                Xhtml::div( "Apply" )->id( "floors_apply" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->gui()->getButton() )->attr( "data-disabled", "true" ) );

        $floorForm->addContent( $floorTable );
        $floorForm->addContent( $floorsError );
        $floorForm->addContent( $floorButtons );
        $content->addContent( $floorForm );

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
        $wrapper = Xhtml::div()->id( self::$ID_CREATOR_CONTENT_WRAPPER );

        // Draw planner toolbar
        $this->drawPlannerToolbar( $wrapper );

        // Add canvas wrapper to wrapper
        $wrapper->addContent( Xhtml::div()->id( self::$ID_CREATOR_CONTENT_CANVAS_WRAPPER ) );

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

    // ... ... /CREATOR


    // ... /DRAW


    // ... CREATE


    /**
     * @param FloorBuildingModel $floor
     * @return AbstractXhtml
     */
    private static function createFloorsRow( $floor )
    {

        // Create row
        $row = Xhtml::div()->class_( Resource::css()->getTableRow(), "floor" )->attr( "data-floor",
                    $floor->getId() );

        // Floor name
        $row->addContent( Xhtml::div( $floor->getName() )->class_( "name" ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::input( $floor->getName(), sprintf( "floor_name[%s]", $floor->getId() ) )->attr(
                                "data-hint", "Name" ) )->class_( "name_edit" ) );

        // Floor map
        $row->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( Xhtml::div()->attr( "data-icon", "map" ) )->attr( "data-type", "file" )->attr("data-name", sprintf( "floor_map[%s]", $floor->getId() ))->class_(
                                        Resource::css()->gui()->getComponent() ) )->class_(
                                Resource::css()->gui()->getGui() ) )->title( "Map" )->class_( "map_edit" ) );

        // Floor order
        $row->addContent(
                Xhtml::div( Xhtml::div()->attr( "data-icon", "up" )->class_( "up" )->title( "Order up" ) )->addContent(
                        Xhtml::div()->attr( "data-icon", "down" )->class_( "down" )->title( "Order down" ) )->addContent(
                        Xhtml::input( $floor->getOrder(), sprintf( "floor_order[%s]", $floor->getId() ) ) )->class_(
                        Resource::css()->getRight(), "order_edit" ) );

        // Floor main
        $row->addContent(
                Xhtml::div( $floor->getMain() ? Xhtml::div()->attr( "data-icon", "star" ) : "" )->class_(
                        Resource::css()->getRight(), "main" ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( Xhtml::div()->attr( "data-icon", "star" ) )->attr( "data-type", "radio" )->attr(
                                        "data-radio-name", "floor_main" )->attr( "data-value", $floor->getId() )->class_(
                                        Resource::css()->gui()->getComponent(), $floor->getMain() ? "checked" : "" ) )->class_(
                                Resource::css()->gui()->getGui() ) )->class_( Resource::css()->getRight(), "main_edit" ) );

        // Return row
        return $row;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>