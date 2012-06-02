<?php

abstract class AppCampusguideMainView extends MainView
{

    // VARIABLES


    public static $ID_APP_WRAPPER = "app_wrapper";
    public static $ID_DISPLAY_WRAPPER = "display_wrapper";
    public static $ID_MENU_WRAPPER = "menu_wrapper";
    public static $ID_PAGE_WRAPPER = "page_wrapper";
    public static $ID_MOBILE_WRAPPER = "mobile_wrapper";
    public static $ID_MOBILE_SCREEN_WRAPPER = "mobile_screen_wrapper";
    public static $ID_MOBILE_MIDDLE_WRAPPER = "mobile_middle_wrapper";
    public static $ID_MOBILE_TOP_WRAPPER = "mobile_top_wrapper";
    public static $ID_MOBILE_BOTTOM_WRAPPER = "mobile_bottom_wrapper";

    /**
     * @var ErrorAppCampusguidePresenterView
     */
    private $errorPresenter;

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
       $this->setErrorPresenter(new ErrorAppCampusguidePresenterView($this));
    }


    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawPage( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawMenu( AbstractXhtml $root );

    /**
     * @see View::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_APP_WRAPPER );

        // Detect mobile/tablet/desktop
        if ( $this->getController()->getMobiledetectApi()->isMobile() || $this->getController()->getMobiledetectApi()->isTablet() )
        {
            $wrapper->addClass(
                    $this->getController()->getMobiledetectApi()->isMobile() ? Resource::css()->campusguide()->app()->getMobile() : Resource::css()->campusguide()->app()->getTablet() );

            // Create display wrapper
            $displayWrapper = Xhtml::div()->id( self::$ID_DISPLAY_WRAPPER );

            // Draw menu to display wrapper
            $menuWrapper = Xhtml::div()->id( self::$ID_MENU_WRAPPER );
            $div = Xhtml::div();
            $this->drawMenu( $div );
            $menuWrapper->addContent( $div );
            $displayWrapper->addContent( $menuWrapper );

            // Create page wrapper
            $pageWrapper = Xhtml::div();

            // Draw page
            if ( $this->getController()->getErrors() )
            {
                $this->drawPageError( $pageWrapper );
            }
            else
            {
                $this->drawPage( $pageWrapper );
            }

            // Add page wrapper to display wrapper
            $displayWrapper->addContent( Xhtml::div( $pageWrapper )->id( self::$ID_PAGE_WRAPPER ) );

            // Add display wrapper to wrapper
            $wrapper->addContent( $displayWrapper );
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

        // Create display wrapper
        $displayWrapper = Xhtml::div()->id( self::$ID_DISPLAY_WRAPPER );

        // Draw menu to screen wrapper
        $menuWrapper = Xhtml::div()->id( self::$ID_MENU_WRAPPER );
        $div = Xhtml::div();
        $this->drawMenu( $div );
        $menuWrapper->addContent( $div );
        $displayWrapper->addContent( $menuWrapper );

        // Create page wrapper
        $pageWrapper = Xhtml::div();

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

        // Add display wrapper to screen wrapper
        $mobileScreenWrapper->addContent( $displayWrapper );

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
    protected function drawPageError( AbstractXhtml $root )
    {

        // Foreach errors
        foreach ( $this->getController()->getErrors() as $error )
        {
            $this->getErrorPresenter()->setError( $error );
            $this->getErrorPresenter()->draw( $root );
        }

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>