<?php

class AdminBuildingBuildingsCmsPageMainView extends AdminCmsPageMainView
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
    private static $ID_BUILDING_OVERLAY_MAP_TITLE_POSITION = "overlay_map_title_position";
    private static $ID_BUILDING_OVERLAY_MAP_BODY_ADDRESS = "overlay_map_body_address";
    private static $ID_BUILDING_OVERLAY_MAP_BODY_POSITION = "overlay_map_body_position";
    private static $ID_BUILDING_OVERLAY_MAP_CANVAS = "map_canvas";
    private static $ID_BUILDING_OVERLAY_MAP_LOADING = "map_loading";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_WRAPPER = "map_search_wrapper";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH = "map_search";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_BUTTON = "map_search_button";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_ADDRESS = "map_search_address";
    private static $ID_BUILDING_OVERLAY_MAP_SEARCH_LOCATION = "map_search_location";

    private static $ID_BUILDING_OVERLAY_MAP_ADDRESS = "map_address";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION = "map_position";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_CENTER = "map_position_center";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_CENTER_BUTTON = "map_position_center_button";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_TOPLEFT = "map_position_topleft";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_TOPLEFT_BUTTON = "map_position_topleft_button";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_TOPRIGHT = "map_position_topright";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_TOPRIGHT_BUTTON = "map_position_topright_button";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_BOTTOMRIGHT = "map_position_bottomright";
    private static $ID_BUILDING_OVERLAY_MAP_POSITION_BOTTOMRIGHT_BUTTON = "map_position_bottomright_button";

    /**
     * @var OverlayCmsPresenterView
     */
    private $overlayPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );

        $this->setOverlayPresenter( new OverlayCmsPresenterView( $view ) );
        $this->getOverlayPresenter()->setId( self::$ID_BUILDING_OVERLAY_MAP );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverlayCmsPresenterView
     */
    public function getOverlayPresenter()
    {
        return $this->overlayPresenter;
    }

    /**
     * @param OverlayCmsPresenterView $overlayPresenter
     */
    public function setOverlayPresenter( OverlayCmsPresenterView $overlayPresenter )
    {
        $this->overlayPresenter = $overlayPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see AbstractPageMainView::getView()
     * @return BuildingsCmsMainView
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
        return $this->isActionEdit() ? Resource::url()->cms()->buildings()->getEditBuildingPage(
                $this->getBuilding()->getId(), $this->getView()->getController()->getMode() ) : Resource::url()->cms()->buildings()->getNewBuildingPage(
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
     * @see PageCmsPageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_WRAPPER;
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageCmsPageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {

        // Add header to root
        $root->addContent( Xhtml::h( 2, $this->getHeaderText() ) );

    }

    /**
     * @see PageCmsPageMainView::drawBody()
     */
    public function drawBody( AbstractXhtml $root )
    {

        // Create fields wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->cms()->getFieldsWrapper() );

        // Add fields to wrapper
        $this->drawFields( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

        // Add map overlay to wrapper
        //         $this->drawMapOverlay( $root );


    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFields( AbstractXhtml $root )
    {

        // Create form
        $form = Xhtml::form()->action( $this->getFormAction() )->method( FormXhtml::$METHOD_POST )->autocomplete(
                false )->attr( "accept-charset", "utf-8" )->id( self::$ID_BUILDING_FORM );

        // NAME/FACILITIES FIELDS


        // Create fields
        $fields = Xhtml::div()->class_( Resource::css()->cms()->getFields() );

        // ... NAME


        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Name" )->class_( Resource::css()->cms()->getRequired() ) );

        $field->addContent(
                Xhtml::div(
                        Xhtml::input( $this->getBuildingAdmin()->getName(), Resource::db()->building()->getFieldName() )->id(
                                Resource::db()->building()->getFieldName() ) ) );

        $fields->addContent( $field );

        // ... /NAME


        // ... FACILITY


        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Facility" )->class_( Resource::css()->cms()->getRequired() ) );

        $fieldFacilities = Xhtml::div();
        $this->drawFieldsFacilities( $fieldFacilities );
        $field->addContent( $fieldFacilities );

        $fields->addContent( $field );

        // ... /FACILITY


        // /NAME/FACILITIES FIELDS


        // Add fields to form
        $form->addContent( $fields );

        // Create building map wrapper
        $buildingMapWrapper = Xhtml::div()->id( "buildings_map_wrapper" )->class_( Resource::css()->getTable() );
        $buildingWrapper = Xhtml::div();
        $mapWrapper = Xhtml::div()->id( "map_wrapper" );

        // BUILDING FIELDS


        // Create fields
        $fields = Xhtml::div()->class_( Resource::css()->cms()->getFields() );

        // ... ADDRESS
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Address" ) );

        $fieldAddress = Xhtml::div()->class_( "address" );
        $this->drawFieldsAddress( $fieldAddress );
        $field->addContent( $fieldAddress );

        $fields->addContent( $field );

        // ... /ADDRESS


        // Overlay
        $fields->addContent(
                Xhtml::div(
                        Xhtml::textarea( json_encode( $this->getBuildingAdmin()->getOverlay() ) )->name(
                                Resource::db()->building()->getFieldOverlay() )->id(
                                Resource::db()->building()->getFieldOverlay() ) ) );

        // /BUILDING FIELDS


        $buildingWrapper->addContent( $fields );

        // MAP


        $mapLoading = Xhtml::div(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading map" ) )->addContent(
                        Xhtml::div( "Loading map..." ) ) )->id( "map_loading" )->class_( Resource::css()->getTable() );
        $mapCanvas = Xhtml::div( $mapLoading )->id( "map_canvas" );

        $mapPlaceAddressButton = Xhtml::div( "Place Address" )->class_( Resource::css()->cms()->getButton() )->id(
                "address_place" );
        $mapPlacePositionButton = Xhtml::div( "Place Position" )->class_( Resource::css()->cms()->getButton() )->id(
                "position_place" );
        $mapClearOverlayButton = Xhtml::div( "Clear Overlay" )->class_( Resource::css()->cms()->getButton() )->id(
                "overlay_clear" );

        $mapWrapper->addContent( $mapPlaceAddressButton, $mapPlacePositionButton, $mapClearOverlayButton );
        $mapWrapper->addContent( $mapCanvas );
        $mapWrapper->addContent(
                Xhtml::div( "Right click on overlay anchor to remove it" )->class_( Resource::css()->cms()->getHint(),
                        Resource::css()->getRight() ) );

        // /MAP


        $buildingMapWrapper->addContent( $buildingWrapper, $mapWrapper );
        $form->addContent( $buildingMapWrapper );

        // Create fields
        $fields = Xhtml::div()->class_( Resource::css()->cms()->getFields() );

        // CANCEL/SAVE FIELD


        $buttons = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );
        $buttons->addContent(
                Xhtml::a( "Cancel" )->href( "javascript:history.back(-1)" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "cross" )->attr( "data-icon-placing", "right" ) );
        $buttons->addContent(
                Xhtml::button( "Save" )->type( ButtonXhtml::$TYPE_SUBMIT )->id( "facility_save" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "check" )->attr( "data-icon-placing", "right" ) );

        $field = Xhtml::div();
        $field->addContent( Xhtml::div( Xhtml::$NBSP ) );
        $field->addContent( Xhtml::div( $buttons )->class_( Resource::css()->getRight() ) );
        $fields->addContent( $field );

        // /CANCEL/SAVE FIELD


        // Add fields to form
        $form->addContent( $fields );

        // Add form to root
        $root->addContent( $form );

    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFieldsAddress( AbstractXhtml $root )
    {

        $table = Xhtml::div()->class_( Resource::css()->getTable() );
        $cell = Xhtml::div();

        // Street name
        $addressName = sprintf( "%s[]", Resource::db()->building()->getFieldAddress() );
        $cell->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 0 ), $addressName )->placeholder(
                        "Streetname" )->id( "address_street" )->title( "Streetname" ) );

        // City
        $cell->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 1 ), $addressName )->placeholder(
                        "City" )->id( "address_city" )->title( "City" ) );

        // Postal
        $cell->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 2 ), $addressName )->placeholder(
                        "Postal" )->id( "address_postal" )->title( "Postal" ) );

        // Country
        $cell->addContent(
                Xhtml::input( Core::arrayAt( $this->getBuildingAdmin()->getAddress(), 3 ), $addressName )->placeholder(
                        "Country" )->id( "address_country" )->title( "Country" ) );

        $table->addContent( $cell );
        $cell = Xhtml::div();

        // Search map button
        $cell->addContent(
                Xhtml::div( "Search" )->class_( Resource::css()->cms()->getButton() )->id( "address_search" ) );

        $table->addContent( $cell );

        // Location/position
        $locationPositionWrapper = Xhtml::div();
        $locationPositionWrapper->addContent(
                Xhtml::input( implode( BuildingUtil::$SPLITTER_LOCATION, $this->getBuildingAdmin()->getLocation() ),
                        Resource::db()->building()->getFieldLocation() )->readonly( true )->placeholder( "Location" )->id(
                        Resource::db()->building()->getFieldLocation() )->title( "Location" ) );
        $locationPositionWrapper->addContent(
                Xhtml::input( implode( BuildingUtil::$SPLITTER_POSITION, $this->getBuildingAdmin()->getPosition() ),
                        Resource::db()->building()->getFieldPosition() )->readonly( true )->placeholder( "Position" )->id(
                        Resource::db()->building()->getFieldPosition() )->title( "Position" ) );

        $root->addContent( $table );
        $root->addContent( $locationPositionWrapper );

    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFieldsPosition( AbstractXhtml $root )
    {

        $positionName = sprintf( "%s[]", Resource::db()->building()->getFieldPosition() );
        $root->addContent(
                Xhtml::input(
                        implode( BuildingUtil::$SPLITTER_POSITION,
                                Core::arrayAt( $this->getBuildingAdmin()->getPosition(), 0, array () ) ), $positionName )->readonly(
                        true )->placeholder( "Center" )->id( "position_center" )->title( "Center" ) );

        $root->addContent(
                Xhtml::input(
                        implode( BuildingUtil::$SPLITTER_POSITION,
                                Core::arrayAt( $this->getBuildingAdmin()->getPosition(), 1, array () ) ), $positionName )->readonly(
                        true )->placeholder( "Top left" )->id( "position_topleft" )->title( "Top left" ) );

        $root->addContent(
                Xhtml::input(
                        implode( BuildingUtil::$SPLITTER_POSITION,
                                Core::arrayAt( $this->getBuildingAdmin()->getPosition(), 2, array () ) ), $positionName )->readonly(
                        true )->placeholder( "Top right" )->id( "position_topright" )->title( "Top right" ) );

        $root->addContent(
                Xhtml::input(
                        implode( BuildingUtil::$SPLITTER_POSITION,
                                Core::arrayAt( $this->getBuildingAdmin()->getPosition(), 3, array () ) ), $positionName )->readonly(
                        true )->placeholder( "Bottom right" )->id( "position_bottomright" )->title( "Bottom right" ) );

        $root->addContent(
                Xhtml::a( "Map" )->class_( Resource::css()->cms()->getButton() )->id( "position_map" )->href(
                        "#map:position" ) );

    }

    /**
     * @param AbstractXhtml root
     */
    private function drawFieldsFacilities( AbstractXhtml $root )
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
                            Resource::url()->cms()->facility()->getFacilityImage( $facility->getId(), null, null,
                                    $this->getView()->getController()->getMode() ) ) )->class_( "image",
                    Resource::css()->getTable() )->title( $facility->getName() );

            $link = Xhtml::a( $facility->getName() )->href(
                    Resource::url()->cms()->facility()->getViewFacilityPage( $facility->getId(),
                            $this->getView()->getController()->getMode() ) )->target( AnchorXhtml::$TARGET_BLANK );
            $div->addContent( Xhtml::div( Xhtml::div( $link ) )->class_( "name" ) );

            // Create image
            $image = Xhtml::img(
                    Resource::url()->cms()->facility()->getFacilityImage( $facility->getId(), null, null,
                            $this->getView()->getController()->getMode() ), $facility->getName() )->class_( "image" );

            // Create name
            $name = Xhtml::div( $facility->getName() )->class_( "name" );

            //             $wrapper->addContent($image);
            //             $wrapper->addContent($name);
            $wrapper->addContent( $div );

            $facilitiesTable->addContent( Xhtml::div( $wrapper ) );
        }

        $facilitiesTable->addContent( Xhtml::div()->class_( Resource::css()->getTableCellFill() ) );

        $facilitiesAll->addContent( Xhtml::div( $facilitiesTable )->class_( "facilities_wrapper" ) );

        // /FACILITIES ALL


        $table->addContent( $facilitySelected );
        $table->addContent( $facilityNone );
        $table->addContent( $facilitiesAll );

        // Input field
        $input = Xhtml::input( $this->getBuildingAdmin()->getFacilityId(),
                Resource::db()->building()->getFieldFacilityId() )->type( InputXhtml::$TYPE_HIDDEN )->id(
                Resource::db()->building()->getFieldFacilityId() );

        // Add table to root
        $root->addContent( $table );

        // Add input to root
        $root->addContent( $input );

    }

    /**
     * @param AbstractXhtml bodyPosition*/
    private function drawMapOverlay( AbstractXhtml $root )
    {

        // Create title
        $title = Xhtml::span();
        $title->addContent( Xhtml::span( "Building Address" )->id( self::$ID_BUILDING_OVERLAY_MAP_TITLE_ADDRESS ) );
        $title->addContent( Xhtml::span( "Building Alignment" )->id( self::$ID_BUILDING_OVERLAY_MAP_TITLE_POSITION ) );

        // Create body
        $body = Xhtml::div();

        // ... Address
        $bodyAddress = Xhtml::div( "Search for building address" )->id(
                self::$ID_BUILDING_OVERLAY_MAP_BODY_ADDRESS );

        // ... Position
        $bodyPosition = Xhtml::div( "Set building alignments" )->id(
                self::$ID_BUILDING_OVERLAY_MAP_BODY_POSITION );

        // ... Map
        $bodyMapLoading = Xhtml::div(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading map" ) )->addContent(
                        Xhtml::div( "Loading map..." ) ) )->id( self::$ID_BUILDING_OVERLAY_MAP_LOADING )->class_(
                Resource::css()->getTable() );
        $bodyMap = Xhtml::div( $bodyMapLoading )->id( self::$ID_BUILDING_OVERLAY_MAP_CANVAS );

        $body->addContent( $bodyAddress );
        $body->addContent( $bodyPosition );
        $body->addContent(
                Xhtml::div( Xhtml::input()->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH ) )->addContent(
                        Xhtml::a( "Search" )->href( "#" )->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH_BUTTON )->class_(
                                Resource::css()->cms()->getButton() )->attr( "data-icon", "search" )->attr(
                                "data-icon-align", "left" ) )->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH_WRAPPER ) );
        //         $body->addContent(
        //                 Xhtml::div( Xhtml::input()->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH ) )->addContent(
        //                         Xhtml::div(
        //                                 Xhtml::div( "Search" )->id( self::$ID_BUILDING_OVERLAY_MAP_SEARCH_BUTTON )->attr(
        //                                         "data-type", "button_icon" )->attr( "data-icon", "search" )->class_(
        //                                         Resource::css()->gui()->getComponent() ) )->class_(
        //                                 Resource::css()->gui()->getGui(), "theme3" ) )->id(
        //                         self::$ID_BUILDING_OVERLAY_MAP_SEARCH_WRAPPER ) );
        $body->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::strong( "Address: " ) )->addContent(
                                Xhtml::span( Xhtml::italic( "No address" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_SEARCH_ADDRESS ) ) )->addContent(
                        Xhtml::div( Xhtml::strong( "Location: " ) )->addContent(
                                Xhtml::span( Xhtml::italic( "No location" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_SEARCH_LOCATION ) )->class_(
                                Resource::css()->getRight() ) )->class_( Resource::css()->getTable() )->id(
                        self::$ID_BUILDING_OVERLAY_MAP_ADDRESS ) );

        $body->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::div( Xhtml::strong( "Center:" ) ) )->addContent(
                                Xhtml::div( Xhtml::italic( "Not placed" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_POSITION_CENTER ) )->addContent(
                                Xhtml::div(
                                        Xhtml::a( "Place" )->href( "#" )->id(
                                                self::$ID_BUILDING_OVERLAY_MAP_POSITION_CENTER_BUTTON )->class_(
                                                Resource::css()->cms()->getButton() ) ) )->class_(
                                Resource::css()->getTableRow() ) )->addContent(
                        Xhtml::div( Xhtml::div( Xhtml::strong( "Top left:" ) ) )->addContent(
                                Xhtml::div( Xhtml::italic( "Not placed" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_POSITION_TOPLEFT ) )->addContent(
                                Xhtml::div(
                                        Xhtml::a( "Place" )->href( "#" )->id(
                                                self::$ID_BUILDING_OVERLAY_MAP_POSITION_TOPLEFT_BUTTON )->class_(
                                                Resource::css()->cms()->getButton() ) ) )->class_(
                                Resource::css()->getTableRow() ) )->addContent(
                        Xhtml::div( Xhtml::div( Xhtml::strong( "Top right:" ) ) )->addContent(
                                Xhtml::div( Xhtml::italic( "Not placed" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_POSITION_TOPRIGHT ) )->addContent(
                                Xhtml::div(
                                        Xhtml::a( "Place" )->href( "#" )->id(
                                                self::$ID_BUILDING_OVERLAY_MAP_POSITION_TOPRIGHT_BUTTON )->class_(
                                                Resource::css()->cms()->getButton() ) ) )->class_(
                                Resource::css()->getTableRow() ) )->addContent(
                        Xhtml::div( Xhtml::div( Xhtml::strong( "Bottom right:" ) ) )->addContent(
                                Xhtml::div( Xhtml::italic( "Not placed" ) )->id(
                                        self::$ID_BUILDING_OVERLAY_MAP_POSITION_BOTTOMRIGHT ) )->addContent(
                                Xhtml::div(
                                        Xhtml::a( "Place" )->href( "#" )->id(
                                                self::$ID_BUILDING_OVERLAY_MAP_POSITION_BOTTOMRIGHT_BUTTON )->class_(
                                                Resource::css()->cms()->getButton() ) ) )->class_(
                                Resource::css()->getTableRow() ) )->class_( Resource::css()->getTable() )->id(
                        self::$ID_BUILDING_OVERLAY_MAP_POSITION ) );

        $body->addContent( $bodyMap );
        //$body->addContent( $bodyMapLoading );


        $this->getOverlayPresenter()->setTitle( $title );
        $this->getOverlayPresenter()->setBody( $body );
        $this->getOverlayPresenter()->draw( $root );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>