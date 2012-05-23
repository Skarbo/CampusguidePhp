<?php

class AdminBuildingBuildingsCmsCampusguidePageMainView extends AdminCmsCampusguidePageMainView
{

    // VARIABLES


    private static $ID_WRAPPER = "admin_building_page_wrapper";
    private static $ID_FIELDS_WRAPPER = "fields_wrapper";
    private static $ID_BUILDING_FORM = "building_form";
    private static $ID_BUILDING_FACILITY = "building_facility";
    private static $ID_BUILDING_FACILITIES_ALL = "facilities_all";
    private static $ID_BUILDING_FACILITY_SELECTED = "facility_selected";
    private static $ID_BUILDING_FACILITY_NONE = "facility_none";
    private static $ID_BUILDING_OVERLAY_MAP = "overlay_map";
    private static $ID_BUILDING_OVERLAY_MAP_TITLE_ADDRESS = "overlay_map_title_address";
    private static $ID_BUILDING_OVERLAY_MAP_TITLE_LOCATION = "overlay_map_title_location";
    private static $ID_BUILDING_OVERLAY_MAP_BODY_ADDRESS = "overlay_map_body_address";
    private static $ID_BUILDING_OVERLAY_MAP_BODY_LOCATION = "overlay_map_body_location";
    private static $ID_BUILDING_OVERLAY_MAP_CANVAS = "map_canvas";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_WRAPPER = "map_search_wrapper";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH = "map_search";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_BUTTON = "map_search_button";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_ADDRESS = "map_search_address";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_LOCATION = "map_search_location";

    /**
     * @var OverlayCmsCampusguidePresenterView
     */
    private $overlayPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );

        $this->setOverlayPresenter( new OverlayCmsCampusguidePresenterView( $view ) );
        $this->getOverlayPresenter()->setId( self::$ID_BUILDING_OVERLAY_MAP );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverlayCmsCampusguidePresenterView
     */
    public function getOverlayPresenter()
    {
        return $this->overlayPresenter;
    }

    /**
     * @param OverlayCmsCampusguidePresenterView $overlayPresenter
     */
    public function setOverlayPresenter( OverlayCmsCampusguidePresenterView $overlayPresenter )
    {
        $this->overlayPresenter = $overlayPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see PageMainView::getView()
     * @return BuildingsCmsCampusguideMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    private function getHeaderText()
    {
        return $this->isActionEdit() ? sprintf( "Edit Building: %s", $this->getBuilding()->getName() ) : "New Building";
    }

    private function getFormAction()
    {
        return $this->isActionEdit() ? Resource::url()->campusguide()->cms()->building()->getEditBuildingPage(
                $this->getBuilding()->getId(), $this->getView()->getController()->getMode() ) : Resource::url()->campusguide()->cms()->building()->getNewBuildingPage(
                $this->getView()->getController()->getMode() );
    }

    /**
     * @return BuildingModel
     */
    private function getBuilding()
    {
        return $this->getView()->getController()->getBuilding();
    }

    /**
     * @return BuildingModel
     */
    private function getBuildingAdmin()
    {
        return $this->getView()->getController()->getBuildingAdmin();
    }

    /**
     * @see PageCmsCampusguidePageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_WRAPPER;
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageCmsCampusguidePageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {

        // Add header to root
        $root->addContent( Xhtml::h( 2, $this->getHeaderText() ) );

    }

    /**
     * @see PageCmsCampusguidePageMainView::drawBody()
     */
    public function drawBody( AbstractXhtml $root )
    {

        // Create fields wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->getFieldsWrapper() );

        // Add fields to wrapper
        $this->drawFields( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

        // Add map overlay to wrapper
        $this->drawMapOverlay( $root );

    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFields( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->getFields() );

        // Create Building name field
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Name" )->class_( Resource::css()->campusguide()->cms()->getRequired() ) );

        $field->addContent(
                Xhtml::div(
                        Xhtml::input( $this->getBuildingAdmin()->getName(), Resource::db()->building()->getFieldName() )->id(
                                Resource::db()->building()->getFieldName() ) )->class_( Resource::css()->getNopadding() ) );

        $table->addContent( $field );

        // Create Building Facility field
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Facility" )->class_( Resource::css()->campusguide()->cms()->getRequired() ) );

        $fieldFacilities = Xhtml::div();
        $this->drawFieldsAcademies( $fieldFacilities );
        $field->addContent( $fieldFacilities );

        $table->addContent( $field );

        // Create Building address field
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Address" ) );

        $fieldAddress = Xhtml::div()->class_( "address", Resource::css()->getNopadding() );

        // ... Street name
        $fieldAddress->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 0 ), sprintf( "%s[]", Resource::db()->building()->getFieldAddress() ) )->id(
                        "address_street" )->title( "Streetname" )->class_( Resource::css()->getDefaultText() ) );

        // ... City
        $fieldAddress->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 1 ), sprintf( "%s[]", Resource::db()->building()->getFieldAddress() ) )->id(
                        "address_city" )->title( "City" )->class_( Resource::css()->getDefaultText() ) );

        // ... Postal
        $fieldAddress->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 2 ), sprintf( "%s[]", Resource::db()->building()->getFieldAddress() ) )->id(
                        "address_postal" )->title( "Postal" )->class_( Resource::css()->getDefaultText() ) );

        // ... Country
        $fieldAddress->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 3 ), sprintf( "%s[]", Resource::db()->building()->getFieldAddress() ) )->id(
                        "address_country" )->title( "Country" )->class_( Resource::css()->getDefaultText() ) );

        // ... Map button
        $fieldAddress->addContent(
                Xhtml::div( Xhtml::div( "Map" )->id( "address_map" )->class_( Resource::css()->gui()->getComponent() ) )->class_(
                        Resource::css()->gui()->getGui(), "theme3" ) );

        $field->addContent( $fieldAddress );

        $table->addContent( $field );

        // Create Building location field
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Location" ) );

        $fieldLocation = Xhtml::div()->class_( Resource::css()->getNopadding() );
        $fieldLocation->addContent(
                Xhtml::div(
                        Xhtml::input( $this->getBuildingAdmin()->getLocation(), Resource::db()->building()->getFieldLocation() )->readonly( true )->class_(
                                Resource::css()->gui()->getComponent() )->attr( "data-type", "input" )->id(
                                Resource::db()->building()->getFieldLocation() ) )->addContent(
                        Xhtml::div()->class_( Resource::css()->gui()->getComponent() )->attr( "data-type", "reset" )->attr(
                                "data-reset-id", Resource::db()->building()->getFieldLocation() )->attr( "data-icon",
                                "cross" ) )->addContent(
                        Xhtml::div( Xhtml::$NBSP )->class_("space") )->addContent(
                        Xhtml::div( "Map" )->id( "location_map" )->class_( Resource::css()->gui()->getComponent() ) )->class_( Resource::css()->gui()->getGui(), "theme3" ) );

        $field->addContent( $fieldLocation );

        $table->addContent( $field );

        // Create cancel/save field
        $buttons = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );
        $buttons->addContent(
                Xhtml::a( "Cancel" )->href( "javascript:history.back(-1)" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "cross" )->attr( "data-icon-placing", "right" ) );
        $buttons->addContent(
                Xhtml::button( "Save" )->type( ButtonXhtml::$TYPE_SUBMIT )->id( "facility_save" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "check" )->attr( "data-icon-placing", "right" )->onclick(
                        sprintf( "javascript: Core.removeDefaultText($('#%s')).submit();", self::$ID_BUILDING_FORM ) ) );

        $field = Xhtml::div();

        $field->addContent( Xhtml::div( Xhtml::$NBSP ) );

        $field->addContent( Xhtml::div( $buttons )->class_( Resource::css()->getRight() ) );

        $table->addContent( $field );

        // Create form
        $form = Xhtml::form()->action( $this->getFormAction() )->method( FormXhtml::$METHOD_POST )->attr("accept-charset", "utf-8")->id(
                self::$ID_BUILDING_FORM );

        // Add table to form
        $form->addContent( $table );

        // Add form to table
        $root->addContent( $form );

    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFieldsAcademies( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() )->id( self::$ID_BUILDING_FACILITY );

        // Create selected Facility
        $facilitySelected = Xhtml::div()->id( self::$ID_BUILDING_FACILITY_SELECTED );

        // Create none Facility
        $facilityNone = Xhtml::div(
                Xhtml::div()->addContent(
                        Xhtml::div( Xhtml::div( Xhtml::div( "?" ) )->class_( Resource::css()->getTableRow() ) )->addContent(
                                Xhtml::div( Xhtml::div( "No facility selected" ) )->class_( "name" ) )->class_( "image",
                                "table" ) )->class_( "facility_wrapper" ) )->id( self::$ID_BUILDING_FACILITY_NONE );

        // FACILITIES ALL


        // Create all Facilities
        $facilitiesAll = Xhtml::div();

        // Create table
        $facilitiesTable = Xhtml::div()->class_( "facilities_content", Resource::css()->getTable() )->attr(
                "data-id", "facilities_slider_wrapper" )->attr( "data-width-parent", ".facilities_wrapper" );

        // Foreach Facilities
        for ( $this->getView()->getController()->getFacilities()->rewind(); $this->getView()->getController()->getFacilities()->valid(); $this->getView()->getController()->getFacilities()->next() )
        {
            $facility = $this->getView()->getController()->getFacilities()->current();

            // Create wrapper
            $wrapper = Xhtml::div()->class_( "facility_wrapper" )->id(
                    sprintf( "facility_%s", $facility->getId() ) );

            $div = Xhtml::div()->style(
                    sprintf( "background-image: url('%s');",
                            Resource::url()->campusguide()->cms()->facility()->getFacilityImage( $facility->getId(), null, null,
                                    $this->getView()->getController()->getMode() ) ) )->class_( "image",
                    Resource::css()->getTable() )->title( $facility->getName() );

            $link = Xhtml::a( $facility->getName() )->href(
                    Resource::url()->campusguide()->cms()->facility()->getViewFacilityPage( $facility->getId(),
                            $this->getView()->getController()->getMode() ) )->target( AnchorXhtml::$TARGET_BLANK );
            $div->addContent( Xhtml::div( Xhtml::div( $link ) )->class_( "name" ) );

            // Create image
            $image = Xhtml::img(
                    Resource::url()->campusguide()->cms()->facility()->getFacilityImage( $facility->getId(), null, null,
                            $this->getView()->getController()->getMode() ), $facility->getName() )->class_( "image" );

            // Create name
            $name = Xhtml::div( $facility->getName() )->class_( "name" );

            //             $wrapper->addContent($image);
            //             $wrapper->addContent($name);
            $wrapper->addContent( $div );

            $facilitiesTable->addContent( Xhtml::div( $wrapper ) );
        }

        $facilitiesTable->addContent(Xhtml::div()->class_(Resource::css()->getTableCellFill()));

        $facilitiesAll->addContent( Xhtml::div( $facilitiesTable )->class_( "facilities_wrapper" ) );

        // /FACILITIES ALL


        $table->addContent( $facilitySelected );
        $table->addContent( $facilityNone );
        $table->addContent( $facilitiesAll );

        // Input field
        $input = Xhtml::input( $this->getBuildingAdmin()->getFacilityId(), Resource::db()->building()->getFieldFacilityId() )->type(
                InputXhtml::$TYPE_HIDDEN )->id( Resource::db()->building()->getFieldFacilityId() );

        // Add table to root
        $root->addContent( $table );

        // Add input to root
        $root->addContent( $input );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawMapOverlay( AbstractXhtml $root )
    {

        // Create title
        $title = Xhtml::span();
        $title->addContent( Xhtml::span( "Building Address" )->id( self::$ID_BUILDING_OVERLAY_MAP_TITLE_ADDRESS ) );
        $title->addContent( Xhtml::span( "Building Location" )->id( self::$ID_BUILDING_OVERLAY_MAP_TITLE_LOCATION ) );

        // Create body
        $body = Xhtml::div();

        // ... Address
        $bodyAddress = Xhtml::div( "Search for building address" )->id(
                self::$ID_BUILDING_OVERLAY_MAP_BODY_ADDRESS );

        // ... Location
        $bodyLocation = Xhtml::div( "Search for building location" )->id(
                self::$ID_BUILDING_OVERLAY_MAP_BODY_LOCATION );

        // ... Map
        $bodyMap = Xhtml::div()->id( self::$ID_BUILDING_OVERLAY_MAP_CANVAS );

        $body->addContent( $bodyAddress );
        $body->addContent( $bodyLocation );
        $body->addContent(
                Xhtml::div( Xhtml::input()->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH ) )->addContent(
                        Xhtml::div(
                                Xhtml::div( "Search" )->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH_BUTTON )->attr(
                                        "data-type", "button_icon" )->attr( "data-icon", "search" )->class_(
                                        Resource::css()->gui()->getComponent() ) )->class_(
                                Resource::css()->gui()->getGui(), "theme3" ) )->id(
                        self::$ID_BUILDING_OVERLAY_MAP_SEARCH_WRAPPER ) );
        $body->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::strong( "Address: " ) )->addContent(
                                Xhtml::span( Xhtml::italic( "No address" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_SEARCH_ADDRESS ) ) )->addContent(
                        Xhtml::div( Xhtml::strong( "Location: " ) )->addContent(
                                Xhtml::span( Xhtml::italic( "No location" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_SEARCH_LOCATION ) )->class_(
                                Resource::css()->getRight() ) )->class_( Resource::css()->getTable() ) );
        $body->addContent( $bodyMap );

        $this->getOverlayPresenter()->setTitle( $title );
        $this->getOverlayPresenter()->setBody( $body );
        $this->getOverlayPresenter()->draw( $root );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>