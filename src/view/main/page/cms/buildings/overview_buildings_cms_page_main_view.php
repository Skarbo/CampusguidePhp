<?php

class OverviewBuildingsCmsPageMainView extends AbstractPageMainView
{

    // VARIABLES


    private static $ID_BUILDINGS_PAGE_WRAPPER = "buildings_page_wrapper";
    private static $ID_BUILDINGS_WRAPPER = "buildings_wrapper";
    private static $ID_BUILDINGS_TABLE = "buildings_table";
    private static $ID_BUILDINGS_TABLE_HEADER = "buildings_table_header";
    private static $ID_BUILDINGS_TABLE_BODY = "buildings_table_body";
    private static $ID_BUILDINGS_TEMPLATE_TABLE = "buildings_template_table";
    private static $ID_BUILDINGS_NONE_TABLE = "buildings_none_table";

    /**
     * @var BuildingBuildingsCmsPresenterView
     */
    private $buildingPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->setBuildingPresenter( new TableBuildingBuildingsCmsPresenterView( $view ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return TableBuildingBuildingsCmsPresenterView
     */
    public function getBuildingPresenter()
    {
        return $this->buildingPresenter;
    }

    /**
     * @param TableBuildingBuildingsCmsPresenterView $buildingPresenter
     */
    public function setBuildingPresenter( TableBuildingBuildingsCmsPresenterView $buildingPresenter )
    {
        $this->buildingPresenter = $buildingPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return BuildingsCmsMainView
     * @see AbstractPresenterView::getView()
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

        // Page wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGS_PAGE_WRAPPER );

        // Draw header to wrapper
        $this->drawHeader( $wrapper );

        // Draw table to wrapper
        $this->drawBuildingsTable( $wrapper );

        // Add Page wrapper to root
        $root->addContent( $wrapper );

    }

    // ... HEADER


    private function drawHeader( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->cms()->page()->getHeaderWrapper() );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // Add header to table
        $table->addContent( Xhtml::div( Xhtml::h( 2, "Buildings" ) ) );

        // Draw sub menu on root
        $cell = Xhtml::div()->class_( Resource::css()->getRight() );
        $this->drawHeaderMenuSub( $cell );
        $table->addContent( $cell );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    private function drawHeaderMenuSub( AbstractXhtml $root )
    {

        // Search GUI
        $search_gui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui(), "theme2" );

        // Search input
        $search_input = Xhtml::input()->type( InputXhtml::$TYPE_TEXT )->autocomplete( false )->title( "Search" )->id(
                "buildings_search" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-type", "input" )->attr(
                "placeholder", "Search" );

        // Reset button
        $reset_button = Xhtml::a()->id( "buildings_search_reset" )->title( "Reset" )->attr( "data-type",
                "reset" )->attr( "data-icon", "cross" )->attr( "data-reset-id", "buildings_search" )->addClass(
                Resource::css()->gui()->getComponent() );

        //         // Delete button
        //         $delete_button = Xhtml::a( "Delete" )->attr( "data-url",
        //                 Resource::url()->cms()->building()->getDeleteBuildingPage( array ( "%s" ),
        //                         $this->getView()->getController()->getMode() ) )->id( "delete_building" )->title( "Delete" )->attr(
        //                 "data-disabled", "true" )->addClass( Resource::css()->gui()->getComponent() );


        // Edit button
        $edit_button = Xhtml::a( "Edit" )->attr( "data-url",
                Resource::url()->cms()->buildings()->getEditBuildingPage( "%s",
                        $this->getView()->getController()->getMode() ) )->id( "edit_building" )->title( "Edit" )->attr(
                "data-disabled", "true" )->addClass( Resource::css()->gui()->getComponent() );

        $search_gui->addContent( $search_input );
        $search_gui->addContent( $reset_button );
        //$search_gui->addContent( $delete_button );
        $search_gui->addContent( $edit_button );

        $root->addContent( $search_gui );

    }

    // ... /HEADER


    // ... FACILITIES


    /**
     * @param AbstractXhtml wrapper
     */
    private function drawBuildingsTable( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_BUILDINGS_WRAPPER );

        // Create table
        $table = Xhtml::table()->id( self::$ID_BUILDINGS_TABLE )->class_(
                Resource::css()->cms()->facility()->getBuildings() );

        // Draw header to table
        $header = Xhtml::thead()->id( self::$ID_BUILDINGS_TABLE_HEADER );
        TableBuildingBuildingsCmsPresenterView::drawHeader( $header );
        $table->addContent( $header );

        // Draw body to table
        $this->drawBuildingsBody( $table );

        // Add "No Buildings" footer to table
        $table->addContent(
                Xhtml::tfoot( Xhtml::tr( Xhtml::td( "No Buildings" ) ) )->id( self::$ID_BUILDINGS_NONE_TABLE )->class_(
                        $this->getView()->getController()->getBuildings()->size() > 0 ? Resource::css()->cms()->getHide() : "" ) );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml body
     */
    private function drawBuildingsBody( AbstractXhtml $root )
    {

        // Foreach Buildings
        for ( $this->getView()->getController()->getBuildings()->rewind(); $this->getView()->getController()->getBuildings()->valid(); $this->getView()->getController()->getBuildings()->next() )
        {
            $building = $this->getView()->getController()->getBuildings()->current();
            // Set Building presenter
            $this->getBuildingPresenter()->setBuilding( $building );
            $this->getBuildingPresenter()->setFacility(
                    $this->getView()->getController()->getFacilities()->getId( $building->getFacilityId() ) );
            $this->getBuildingPresenter()->setFloors(
                    $this->getView()->getController()->getBuildingFloors()->getForeignList( $building->getId() ) );

            // Draw Facility to root
            $this->getBuildingPresenter()->draw( $root );

        }

    }

    // ... /FACILITIES


    // /FUNCTIONS


}

?>