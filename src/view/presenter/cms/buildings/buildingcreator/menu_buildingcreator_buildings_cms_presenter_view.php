<?php

class MenuBuildingcreatorBuildingsCmsPresenterView extends PresenterView
{

    // VARIABLES


    private static $ID_BUILDINGCREATOR_MENU_WRAPPER = "buildingcreator_menu_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_LEFT_WRAPPER = "buildingcreator_menu_left_wrapper";
    private static $ID_BUILDINGCREATOR_MENU_RIGHT_WRAPPER = "buildingcreator_menu_right_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPresenterView::getView()
     * @return BuildingcreatorBuildingsCmsPageMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    // ... /GET


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
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

    // /FUNCTIONS


}

?>