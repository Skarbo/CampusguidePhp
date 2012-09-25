<?php

abstract class AppCampusguideMainView extends MainView
{

    // VARIABLES


    public static $ID_APP_WRAPPER = "app_wrapper";
    public static $ID_DISPLAY_WRAPPER = "display_wrapper";
    public static $ID_MENU_TOP_WRAPPER = "menu_top_wrapper";
    public static $ID_MENU_BOTTOM_WRAPPER = "menu_bottom_wrapper";
    public static $ID_PAGE_WRAPPER = "page_wrapper";
    public static $ID_MOBILE_WRAPPER = "mobile_wrapper";
    public static $ID_MOBILE_SCREEN_WRAPPER = "mobile_screen_wrapper";
    public static $ID_MOBILE_MIDDLE_WRAPPER = "mobile_middle_wrapper";
    public static $ID_MOBILE_TOP_WRAPPER = "mobile_top_wrapper";
    public static $ID_MOBILE_BOTTOM_WRAPPER = "mobile_bottom_wrapper";

    private static $ID_SEARCH_OVERLAY = "search_overlay";

    /**
     * @var ErrorAppCampusguidePresenterView
     */
    private $errorPresenter;
    /**
     * @var OverlayAppCampusguidePresenterView
     */
    private $searchOverlayPresenter;
    /**
     * @var ActionbarAppCampusguidePresenterView
     */
    private $actionbarPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return ErrorAppCampusguidePresenterView
     */
    public function getErrorPresenter()
    {
        return $this->errorPresenter;
    }

    /**
     * @param ErrorAppCampusguidePresenterView $errorPresenter
     */
    public function setErrorPresenter( ErrorAppCampusguidePresenterView $errorPresenter )
    {
        $this->errorPresenter = $errorPresenter;
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


    /**
     * @return AppCampusguideMainController
     * @see View::getController()
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return ActionbarAppCampusguidePresenterView
     */
    protected function getActionbarPresenter()
    {
        return $this->actionbarPresenter;
    }

    // ... /GET


    // ... IS


    protected function isNoCache()
    {
        return true;
    }

    // ... /IS


    /**
     * @see View::before()
     */
    public function before()
    {
        $this->setErrorPresenter( new ErrorAppCampusguidePresenterView( $this ) );
        $this->setSearchOverlayPresenter( new OverlayAppCampusguidePresenterView( $this ) );
        $this->actionbarPresenter = new ActionbarAppCampusguidePresenterView( $this );
    }

    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawPage( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom );

    /**
     * @see View::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_APP_WRAPPER );

        // Detect device
        if (  $this->getController()->getMobiledetectApi()->isDevice() )
        {
            $wrapper->attr("data-fitparent", "body");
            $wrapper->addClass(
                    $this->getController()->getMobiledetectApi()->isMobile() ? Resource::css()->campusguide()->app()->getMobile() : Resource::css()->campusguide()->app()->getTablet() );

            // Draw display wrapper
            $this->drawDisplayWrapper( $wrapper );

        }
        else
        {
            $wrapper->addClass( Resource::css()->campusguide()->app()->getDesktop() );
            $this->drawDesktopWrapper( $wrapper );
        }

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawDesktopWrapper( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div();

        // Create mobile screen wrapper
        $mobileScreenWrapper = Xhtml::div()->id( self::$ID_MOBILE_SCREEN_WRAPPER );

        // Draw display wrapper
        $this->drawDisplayWrapper( $mobileScreenWrapper );

        // Create mobile top wrapper
        $mobileTopWrapper = Xhtml::div( Xhtml::div( Xhtml::div( Xhtml::$NBSP ) ) )->id(
                self::$ID_MOBILE_TOP_WRAPPER );

        // Create mobile bottom wrapper
        $mobileBottomWrapper = Xhtml::div( Xhtml::div( Xhtml::div( Xhtml::$NBSP ) ) )->id(
                self::$ID_MOBILE_BOTTOM_WRAPPER );

        // Create mobile wrapper
        $mobileWrapper = Xhtml::div( $mobileTopWrapper )->addContent(
                Xhtml::div( $mobileScreenWrapper )->id( self::$ID_MOBILE_MIDDLE_WRAPPER ) )->addContent(
                $mobileBottomWrapper )->id( self::$ID_MOBILE_WRAPPER );

        // Add mobile wrapper to wrapper
        $wrapper->addContent( $mobileWrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawDisplayWrapper( AbstractXhtml $root )
    {

        // Create display wrapper
        $displayWrapper = Xhtml::div()->id( self::$ID_DISPLAY_WRAPPER );

        // DRAW MENU


        $menuTopWrapper = Xhtml::div()->class_( "menu_wrapper" )->id( self::$ID_MENU_TOP_WRAPPER );
        $menuBottomWrapper = Xhtml::div()->class_( "menu_wrapper" )->id( self::$ID_MENU_BOTTOM_WRAPPER );
        $menuTopDiv = Xhtml::div();
        $menuBottomDiv = Xhtml::div();

        $this->drawMenu( $menuTopDiv, $menuBottomDiv );

        $menuTopWrapper->addContent( $menuTopDiv );
        $menuBottomWrapper->addContent( $menuBottomDiv );

        // /DRAW MENU


        // Add top menu to display wrapper
        $displayWrapper->addContent( $menuTopWrapper );

        // Create page wrapper
        $pageWrapper = Xhtml::div();

        // Draw Actionbar menu
        $this->getActionbarPresenter()->drawMenu($pageWrapper);

        // Draw page
        if ( $this->getController()->getErrors() )
        {
            $this->drawPageError( $pageWrapper );
        }
        else
        {
            $this->drawPage( $pageWrapper );
        }

        // Add page wrapper to mobile screen wrapper
        $displayWrapper->addContent( Xhtml::div( $pageWrapper )->id( self::$ID_PAGE_WRAPPER ) );

        // Add bottom menu to display wrapper
        $displayWrapper->addContent( $menuBottomWrapper );

        // Add display wrapper to wrapper
        $root->addContent( $displayWrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawPageError( AbstractXhtml $root )
    {

        // Foreach errors
        foreach ( $this->getController()->getErrors() as $error )
        {
            $this->getErrorPresenter()->setError( $error );
            $this->getErrorPresenter()->draw( $root );
        }

    }

    // ... ... SEARCH


    /**
     * @param AbstractXhtml $root
     */
    protected function drawOverlaySearch( AbstractXhtml $root )
    {

        // BODY


        $body = Xhtml::div()->id( "search_wrapper" );

        // ... SEARCH INPUT


        $searchInputWrapper = Xhtml::div()->id( "search_input_wrapper" );
        $searchButton = Xhtml::div(
                Xhtml::div()->title( "Search" )->attr( "data-icon", "search" )->id( "search_button" )->class_(
                        Resource::css()->campusguide()->app()->getTouch() ) );
        $searchInput = Xhtml::div(
                Xhtml::div(
                        Xhtml::input()->autocomplete( false )->placeholder( "Search..." )->title( "Search..." )->id(
                                "search_input" ) ) );
        $searchReset = Xhtml::div(
                Xhtml::img( Resource::image()->icon()->getSpinnerCircle(), "Searching..." )->id( "search_spinner" )->class_(
                        Resource::css()->getHide() ) )->addContent(
                Xhtml::div()->title( "Search" )->attr( "data-icon", "cross" )->id( "search_reset" )->class_(
                        Resource::css()->campusguide()->app()->getTouch() ) );
        $searchInputWrapper->addContent( $searchInput );
        $searchInputWrapper->addContent( $searchReset );
        $searchInputWrapper->addContent( $searchButton );

        // ... /SEARCH INPUT


        // ... SEARCH RESULT


        $searchResultWrapper = Xhtml::div()->id( "search_result_wrapper" );

        $searchResult = Xhtml::div()->id( "search_result" );

        $searchResultTable = Xhtml::table()->id( "search_result_table" );

        // ... ... TEMPLATE


        $this->drawOverlaySearchTemplate( $searchResultTable );

        // ... ... /TEMPLATE


        // ... ... NO RESULT


        $searchResultTableNoresult = Xhtml::tfoot()->id( "search_result_noresult" );
        $searchResultTableRow = Xhtml::tr( Xhtml::td( "No result" ) );

        $searchResultTableNoresult->addContent( $searchResultTableRow );
        $searchResultTable->addContent( $searchResultTableNoresult );

        // ... ... /NO RESULT


        $searchResult->addContent( $searchResultTable );
        $searchResultWrapper->addContent( $searchResult );

        // ... /SEARCH RESULT


        $body->addContent( $searchInputWrapper );
        $body->addContent( $searchResultWrapper );

        // /BODY


        // Draw overlay
        $this->getSearchOverlayPresenter()->setId( self::$ID_SEARCH_OVERLAY );
        $this->getSearchOverlayPresenter()->setFitParent( "true" );
        $this->getSearchOverlayPresenter()->setTitle( "Search" );
        $this->getSearchOverlayPresenter()->setBody( $body );
        $this->getSearchOverlayPresenter()->draw( $root );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawOverlaySearchTemplate( AbstractXhtml $root )
    {

    }

    // ... ... /SEARCH


    // ... /DRAW


    // /FUNCTIONS


}

?>