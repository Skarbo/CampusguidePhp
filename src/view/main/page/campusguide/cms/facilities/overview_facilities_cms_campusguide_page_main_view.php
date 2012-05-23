<?php

class OverviewFacilitiesCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    private static $ID_FACILITIES_PAGE_WRAPPER = "facilities_page_wrapper";
    private static $ID_FACILITIES_WRAPPER = "facilities_wrapper";
    private static $ID_FACILITIES_TABLE = "facilities_table";
    private static $ID_FACILITIES_TABLE_HEADER = "facilities_table_header";
    private static $ID_FACILITIES_TABLE_BODY = "facilities_table_body";
    private static $ID_FACILITIES_TEMPLATE_TABLE = "facilities_template_table";
    private static $ID_FACILITIES_NONE_TABLE = "facilities_none_table";

    /**
     * @var FacilityFacilitiesCmsCampusguidePresenterView
     */
    private $facilityPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->setFacilityPresenter( new FacilityFacilitiesCmsCampusguidePresenterView( $view ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return FacilityFacilitiesCmsCampusguidePresenterView
     */
    public function getFacilityPresenter()
    {
        return $this->facilityPresenter;
    }

    /**
     * @param FacilityFacilitiesCmsCampusguidePresenterView $facilityPresenter
     */
    public function setFacilityPresenter( FacilityFacilitiesCmsCampusguidePresenterView $facilityPresenter )
    {
        $this->facilityPresenter = $facilityPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return FacilitiesCmsCampusguideMainView
     * @see PresenterView::getView()
     */
    public function getView()
    {
        return parent::getView();
    }

    // ... /GET


    /**
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Page wrapper
        $wrapper = Xhtml::div()->id( self::$ID_FACILITIES_PAGE_WRAPPER );

        // Draw header to wrapper
        $this->drawHeader( $wrapper );

        // Success
        if ( CmsCampusguideMainController::getQuerySuccess() )
        {
            $wrapper->addContent(
                    Xhtml::div(
                            $this->getView()->getController()->getLocale()->facility()->getSuccess(
                                    CmsCampusguideMainController::getQuerySuccess() ) )->class_(
                            Resource::css()->campusguide()->cms()->getSuccess() ) );
        }

        // Draw table to wrapper
        $this->drawFacilitiesTable( $wrapper );

        // Add Page wrapper to root
        $root->addContent( $wrapper );

    }

    // ... HEADER


    private function drawHeader( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->page()->getHeaderWrapper() );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // Add header to table
        $table->addContent( Xhtml::div( Xhtml::h( 2, "Facilities" ) ) );

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
        $search_gui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui() );

        // Search input
        $search_input = Xhtml::input()->autocomplete( InputXhtml::$AUTOCOMPLETE_OFF )->type(
                InputXhtml::$TYPE_TEXT )->title( "Search" )->id( "facilities_search" )->addClass(
                Resource::css()->getDefaultText(), Resource::css()->gui()->getComponent() )->attr( "data-type", "input" );

        // Reset button
        $reset_button = Xhtml::a()->id( "facilities_search_reset" )->title( "Reset" )->attr( "data-type",
                "reset" )->attr( "data-icon", "cross" )->attr( "data-reset-id", "facilities_search" )->addClass(
                Resource::css()->gui()->getComponent() );

        // Delete button
        $delete_button = Xhtml::a( "Delete" )->attr( "data-url",
                Resource::url()->campusguide()->cms()->facility()->getDeleteFacilityPage( array ( "%s" ),
                        $this->getView()->getController()->getMode() ) )->id( "delete_facility" )->title( "Delete" )->attr(
                "data-disabled", "true" )->addClass( Resource::css()->gui()->getComponent() );

        // Edit button
        $edit_button = Xhtml::a( "Edit" )->attr( "data-url",
                Resource::url()->campusguide()->cms()->facility()->getEditFacilityPage( "%s",
                        $this->getView()->getController()->getMode() ) )->id( "edit_facility" )->title( "Edit" )->attr(
                "data-disabled", "true" )->addClass( Resource::css()->gui()->getComponent() );

        $search_gui->addContent( $search_input );
        $search_gui->addContent( $reset_button );
        $search_gui->addContent( $delete_button );
        $search_gui->addContent( $edit_button );

        $root->addContent( $search_gui );

    }

    // ... /HEADER


    // ... FACILITIES


    /**
     * @param AbstractXhtml wrapper
     */
    private function drawFacilitiesTable( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_FACILITIES_WRAPPER );

        // Create table
        $table = Xhtml::table()->id( self::$ID_FACILITIES_TABLE )->class_(
                Resource::css()->campusguide()->cms()->facility()->getFacilities() );

        // Draw header to table
        $header = Xhtml::thead()->id( self::$ID_FACILITIES_TABLE_HEADER );
        FacilityFacilitiesCmsCampusguidePresenterView::drawHeader( $header );
        $table->addContent( $header );

        // Draw body to table
        $this->drawFacilitiesBody( $table );

        // Add "No Facilities" footer to table
        $table->addContent(
                Xhtml::tfoot( Xhtml::tr( Xhtml::td( "No Facilities" )->colspan( 5 ) ) )->id(
                        self::$ID_FACILITIES_NONE_TABLE )->class_(
                        $this->getView()->getController()->getFacilities()->size() > 0 ? Resource::css()->campusguide()->cms()->getHide() : "" ) );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml body
     */
    private function drawFacilitiesBody( AbstractXhtml $root )
    {

        // Foreach Facilities
        for ( $this->getView()->getController()->getFacilities()->rewind(); $this->getView()->getController()->getFacilities()->valid(); $this->getView()->getController()->getFacilities()->next() )
        {
            $facility = $this->getView()->getController()->getFacilities()->current();

            // Set Facility presenter
            $this->getFacilityPresenter()->setFacility( $facility );
            $this->getFacilityPresenter()->setBuildings(
                    $this->getView()->getController()->getBuildings()->getFacilities( array ( $facility->getId() ) ) );

            // Draw Facility to root
            $this->getFacilityPresenter()->draw( $root );

        }

    }

    // ... /FACILITIES


    // /FUNCTIONS


}

?>