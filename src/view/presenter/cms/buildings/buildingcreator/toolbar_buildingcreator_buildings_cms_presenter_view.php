<?php

class ToolbarBuildingcreatorBuildingsCmsPresenterView extends PresenterView
{

    // VARIABLES


    private static $ID_CREATOR_CONTENT_TOOLBAR_WRAPPER = "buildingcreator_planner_content_toolbar_wrapper";

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

        $left->addContent( $gui );

        // Create gui
        $gui = Xhtml::div()->addClass( Resource::css()->gui()->getGui(), "theme2" );
        $gui->addContent(
                Xhtml::a( Xhtml::div( "Tree" ) )->addClass( Resource::css()->gui()->getComponent() )->title( "Tree" )->id(
                        "toolbar_test" ) );

        $left->addContent( $gui );

        // Test jquery ui
//         $test = Xhtml::div( Xhtml::div( "Test", "#" )->class_( "test_ui" ) )->class_( "toolsui" );
        $elementDeviceRouter =
                Xhtml::div(
                        Xhtml::input()->type( InputXhtml::$TYPE_CHECKBOX )->autocomplete( false )->id(
                                "element_device_router" ) )->addContent(
                                        Xhtml::label( "Router Device" )->for_( "element_device_router" ) );
        $left->addContent( $elementDeviceRouter );

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

    // /FUNCTIONS


}

?>