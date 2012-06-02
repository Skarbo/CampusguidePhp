<?php

class MapAppCampusguideMainView extends AppCampusguideMainView
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

    private static $ID_MAP_PAGE_WRAPPER = "map_page_wrapper";
    private static $ID_MAP_WRAPPER = "map_wrapper";
    private static $ID_MAP_CANVAS = "map_canvas";
    private static $ID_MAP_LOADER = "map_loader";
    private static $ID_MAP_BUILDING_OVERLAY = "map_building_overlay";
    private static $ID_MAP_SEARCH_OVERLAY = "map_search_overlay";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverlayAppCampusguidePresenterView
     */
    private function getOverlayPresenter()
    {
        return $this->overlayPresenter;
    }

    /**
     * @param OverlayAppCampusguidePresenterView $overlayPresenter
     */
    private function setOverlayPresenter( OverlayAppCampusguidePresenterView $overlayPresenter )
    {
        $this->overlayPresenter = $overlayPresenter;
    }

    /**
     * @return OverlayAppCampusguidePresenterView
     */
    public function getSearchOverlayPresenter()
    {
        return $this->searchOverlayPresenter;
    }

    /**
     * @param OverlayAppCampusguidePresenterView $searchOverlayPresenter
     */
    public function setSearchOverlayPresenter( OverlayAppCampusguidePresenterView $searchOverlayPresenter )
    {
        $this->searchOverlayPresenter = $searchOverlayPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... /GET


    /**
     * @see View::before()
     */
    public function before()
    {
        $this->setOverlayPresenter( new OverlayAppCampusguidePresenterView( $this ) );
        $this->setSearchOverlayPresenter( new OverlayAppCampusguidePresenterView( $this ) );
    }

    // ... DRAW


    /**
     * @see AppCampusguideMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", AppCampusguideMainView::$ID_PAGE_WRAPPER ) );

        // Draw overlay to wrapper
        $this->drawOverlay( $wrapper );

        // Draw search overlay to wrapper
        $this->drawOverlaySearch( $wrapper );

        // Draw map to wrapper
        $this->drawMap( $wrapper );

        // Draw building slider to wrapper
        $this->drawBuildingSlider( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    protected function drawMenu( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // MENU


        // Search
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->id( "menu_button_search" )->attr( "data-icon", "search" )->title( "Search" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // Location
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->id( "menu_button_location" )->attr( "data-icon", "location" )->title(
                                "Location" )->class_( Resource::css()->campusguide()->app()->getTouch() ) ) );

        // Layers
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->attr( "data-icon", "layers" )->title( "Layers" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // More
        $table->addContent(
                Xhtml::div(
                        Xhtml::div( "" )->attr( "data-icon", "more" )->title( "More" )->class_(
                                Resource::css()->campusguide()->app()->getTouch() ) ) );

        // /MENU


        // Add table to root
        $root->addContent( $table );

        // Sub menu
        $menuSub = Xhtml::div()->attr( "data-fitparent-width", "true" )->class_( "sub_wrapper",
                Resource::css()->getHide() );
        $this->drawMenuSub( $menuSub );
        $root->addContent( $menuSub );

    }

    protected function drawMenuSub( AbstractXhtml $root )
    {

        // Arrow
        $arrow = Xhtml::div()->class_( "arrow-up" );

        $menu = Xhtml::div()->class_( "sub" );

        // POSITION


        $position = Xhtml::div()->id( "menu_sub_position" )->class_( Resource::css()->getHide() );

        $row = Xhtml::div()->id( "menu_sub_position_setposition" )->class_(
                Resource::css()->campusguide()->app()->getTouch() );
        $row->addContent( Xhtml::div( Xhtml::div()->attr( "data-icon", "location_pin" ) ) );
        $row->addContent( Xhtml::div( "Set position" ) );

        $position->addContent( $row );
        $menu->addContent( Xhtml::div( $position ) );

        // /POSITION


        $root->addContent( $arrow );
        $root->addContent( $menu );

        /*
        <div data-fitparent-width="true" class="sub" style="width: 320px;">
            <div>
                <div style="width: 0pt; height: 0pt; border-left: 5px solid transparent; border-right: 5px solid transparent; vertical-align: top; display: block; margin-left: 116px; border-bottom: 5px solid rgb(102, 102, 102);"></div>
            <div style="padding: 0.3em; border-radius: 0.2em 0.2em 0.2em 0.2em; margin: 0pt 1.5em; background-color: rgb(102, 102, 102); color: white;">
                <div>
                    <span data-icon="location" style="font-size: 1.5em;"></span> <span style="font-weight: bold; padding-left: 0.4em;">Set position</span>
                </div>
            </div>
        </div>
        */

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawMap( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_MAP_WRAPPER );

        // Create map loader wrapper
        $mapLoaderWrapper = Xhtml::div(
                Xhtml::div( Xhtml::img( Resource::image()->icon()->getSpinnerBar(), "Loading map" ) )->addContent(
                        Xhtml::div( "Loading map..." ) ) )->id( self::$ID_MAP_LOADER )->class_(
                Resource::css()->getTable() );
        $wrapper->addContent( $mapLoaderWrapper );

        // Create map canvas
        $mapCanvas = Xhtml::div()->id( self::$ID_MAP_CANVAS )->class_( Resource::css()->getHide() );

        // Add map canvas to wrapper
        $wrapper->addContent( $mapCanvas );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawOverlay( AbstractXhtml $root )
    {

        // MENU


        $menu = Xhtml::div()->class_( Resource::css()->campusguide()->app()->getOverlayMenu() );

        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "direction" ) )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "Take me there" )->href( "#" )->target( AnchorXhtml::$TARGET_BLANK )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuTakemethere() )->attr( "data-url",
                                Resource::url()->campusguide()->getGoogleDirections() ) ) );
        $menu->addContent( $row );

        $row = Xhtml::div();
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( Xhtml::span( "" )->attr( "data-icon", "home" ) )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() ) ) );
        $row->addContent(
                Xhtml::div(
                        Xhtml::a( "See building" )->href( "#" )->class_(
                                Resource::css()->campusguide()->app()->map()->getMenuView() ) ) );
        $menu->addContent( $row );

        // /MENU


        // Draw overlay
        $this->getOverlayPresenter()->setId( self::$ID_MAP_BUILDING_OVERLAY );
        $this->getOverlayPresenter()->setFitParent( "true" );
        $this->getOverlayPresenter()->setTitle( "Header" );
        $this->getOverlayPresenter()->setBody( $menu );
        $this->getOverlayPresenter()->draw( $root );

    }

    /**
     * @param AbstractXhtml searchIcon*/
    protected function drawOverlaySearch( AbstractXhtml $root )
    {

        // BODY


        $body = Xhtml::div()->id( "search_wrapper" );

        // ... SEARCH INPUT


        $searchInputWrapper = Xhtml::div()->id( "search_input_wrapper" );
        $searchButton = Xhtml::div( Xhtml::div()->title("Search")->attr( "data-icon", "search" )->id( "search_button" )->class_(Resource::css()->campusguide()->app()->getTouch()) );
        $searchInput = Xhtml::div(
                Xhtml::div( Xhtml::input()->autocomplete(InputXhtml::$AUTOCOMPLETE_OFF)->title( "Search..." )->id( "search_input" )->attr( "data-hint", "true" ) ) );
        $searchReset = Xhtml::div(
                Xhtml::img( Resource::image()->icon()->getSpinnerCircle(), "Searching..." )->id( "search_spinner" )->class_(
                        Resource::css()->getHide() ) )->addContent(
                Xhtml::div()->title("Search")->attr( "data-icon", "cross" )->id( "search_reset" )->class_(
                        Resource::css()->campusguide()->app()->getTouch() ) );
        $searchInputWrapper->addContent( $searchInput );
        $searchInputWrapper->addContent( $searchReset );
        $searchInputWrapper->addContent( $searchButton );

        // ... /SEARCH INPUT


        // ... SEARCH RESULT


        $searchResultWrapper = Xhtml::div()->id( "search_result_wrapper" );

        $searchResult = Xhtml::div()->id( "search_result" );

        $searchResultTable = Xhtml::table()->id("search_result_table");

        // ... ... TEMPLATE


        // Building template
        $searchResultTableTemplateBuilding = Xhtml::tbody()->class_( "search_result_body", Resource::css()->getHide() )->id( "search_result_template_building" );

        $searchResultTableRowFirst = Xhtml::tr()->class_("search_result_row_first");
        $searchResultTableRowSecond = Xhtml::tr()->class_("search_result_row_second");

        // ... Icon
        $searchResultTableCellIcon = Xhtml::td()->class_( "search_result_icon" );
        $searchResultTableCellIcon->addContent( Xhtml::div()->attr( "data-icon", "home" ) );

        // ... Title
        $searchResultTableCellTitle = Xhtml::td( "Building" )->class_( "search_result_title" );

        // ... Description
        $searchResultTableCellDescription = Xhtml::td( "Description" )->colspan( 3 )->class_(
                "search_result_description" );

        // ... Direction
        $searchResultTableCellDirection = Xhtml::td( "000m" )->class_( "search_result_direction" );

        $searchResultTableRowFirst->addContent( $searchResultTableCellIcon )->addContent( $searchResultTableCellTitle )->addContent(
                $searchResultTableCellDirection );
        $searchResultTableRowSecond->addContent( $searchResultTableCellDescription );
        $searchResultTableTemplateBuilding->addContent( $searchResultTableRowFirst );
        $searchResultTableTemplateBuilding->addContent( $searchResultTableRowSecond );
        $searchResultTable->addContent( $searchResultTableTemplateBuilding );

        // ... ... /TEMPLATE

        // ... ... NO RESULT

        $searchResultTableNoresult = Xhtml::tfoot()->id("search_result_noresult");
        $searchResultTableRow = Xhtml::tr( Xhtml::td( "No result" ) );

        $searchResultTableNoresult->addContent($searchResultTableRow);
        $searchResultTable->addContent( $searchResultTableNoresult );

        // ... ... /NO RESULT


        $searchResult->addContent( $searchResultTable );
        $searchResultWrapper->addContent( $searchResult );

        // ... /SEARCH RESULT


        $body->addContent( $searchInputWrapper );
        $body->addContent( $searchResultWrapper );

        // /BODY


        // Draw overlay
        $this->getOverlayPresenter()->setId( self::$ID_MAP_SEARCH_OVERLAY );
        $this->getOverlayPresenter()->setFitParent( "true" );
        $this->getOverlayPresenter()->setTitle( "Search" );
        $this->getOverlayPresenter()->setBody( $body );
        $this->getOverlayPresenter()->draw( $root );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawBuildingSlider( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( "building_slider_wrapper" )->class_( Resource::css()->getHide() );

        $div = Xhtml::div( Xhtml::span( "" )->attr( "data-icon", "home" ) )->class_( "building" );

        $wrapper->addContent( $div );

        $root->addContent( $wrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>