<?php

class BuildingAppCampusguideMainView extends AppCampusguideMainView
{

    // VARIABLES


    /**
     * @var OverlayAppCampusguidePresenterView
     */
    private $overlayPresenter;
    /**
     * @var OverlayAppCampusguidePresenterView
     */
    private $searchOverlayPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    // ... DRAW


    /**
     * @see AppCampusguideMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", AppCampusguideMainView::$ID_PAGE_WRAPPER ) );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    protected function drawMenu( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // MENU


        // Map
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->id( "menu_button_map" )->attr( "data-icon", "home" )->title( "Back to map" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // Building
        $table->addContent(
                Xhtml::div( "Building" ) );

        // More
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // /MENU


        // Add table to root
        $root->addContent( $table );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>