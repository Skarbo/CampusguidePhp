<?php

abstract class CmsCampusguideMainView extends MainView
{

    // VARIABLES


    public static $ID_CMS_WRAPPER = "cms_wrapper";
    public static $ID_CMS_MAIN_WRAPPER = "main_cms_wrapper";
    public static $ID_HEADER_WRAPPER = "header_wrapper";
    public static $ID_OVERLAY = "overlay";

    /**
     * @var PageMenuCmsCampusguidePresenterView
     */
    private $pageMenuPresenter;
    /**
     * @var ControllerMenuCmsCampusguidePresenterView
     */
    private $controllerMenuPresenter;

    /**
     * @var ErrorCmsCampusguidePresenterView
     */
    private $errorPresenter;
    /**
     * @var OverlayCmsCampusguidePresenterView
     */
    private $overlayPresenter;
    /**
     * @var QueueCmsCampusguidePresenterView
     */
    private $queuePresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return PageMenuCmsCampusguidePresenterView
     */
    protected function getPageMenuPresenter()
    {
        return $this->pageMenuPresenter;
    }

    /**
     * @param PageMenuCmsCampusguidePresenterView $menuPresenter
     */
    protected function setPageMenuPresenter( PagePageMenuCmsCampusguidePresenterView $menuPresenter )
    {
        $this->pageMenuPresenter = $menuPresenter;
    }

    /**
     * @return ControllerMenuCmsCampusguidePresenterView
     */
    private function getControllerMenuPresenter()
    {
        return $this->controllerMenuPresenter;
    }

    /**
     * @param ControllerMenuCmsCampusguidePresenterView $controllerMenuPresenter
     */
    private function setControllerMenuPresenter( ControllerMenuCmsCampusguidePresenterView $controllerMenuPresenter )
    {
        $this->controllerMenuPresenter = $controllerMenuPresenter;
    }

    /**
     * @return ErrorCmsCampusguidePresenterView
     */
    public function getErrorPresenter()
    {
        return $this->errorPresenter;
    }

    /**
     * @param ErrorCmsCampusguidePresenterView $errorPresenter
     */
    public function setErrorPresenter( ErrorCmsCampusguidePresenterView $errorPresenter )
    {
        $this->errorPresenter = $errorPresenter;
    }

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

    /**
     * @return QueueCmsCampusguidePresenterView
     */
    public function getQueuePresenter()
    {
        return $this->queuePresenter;
    }

    /**
     * @param QueueCmsCampusguidePresenterView $canvasPresenter
     */
    public function setQueuePresenter( QueueCmsCampusguidePresenterView $canvasPresenter )
    {
        $this->queuePresenter = $canvasPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return CmsCampusguideMainController
     * @see View::getController()
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return string Wrapper id
     */
    protected abstract function getWrapperId();

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
        $this->setPageMenuPresenter( new PageMenuCmsCampusguidePresenterView( $this ) );
        $this->setControllerMenuPresenter( new ControllerMenuCmsCampusguidePresenterView( $this ) );
        $this->setErrorPresenter( new ErrorCmsCampusguidePresenterView( $this ) );
        $this->setOverlayPresenter( new OverlayCmsCampusguidePresenterView( $this ) );

        // ... Queue
        if ( $this->getController()->getQueue() )
        {
            $this->setQueuePresenter(
                    new QueueCmsCampusguidePresenterView( $this, $this->getController()->getQueue() ) );
        }

        // Do page menu
        $this->doPageMenu();

        // Do controller menu
        $this->doControllerMenu();
    }

    // ... DO


    /**
     * Add items to page menu
     */
    protected abstract function doPageMenu();

    /**
     * Add items to controller menu
     */
    protected function doControllerMenu()
    {

        // Menu
        $this->getControllerMenuPresenter()->addItem( "Home",
                Resource::url()->campusguide()->cms()->getHome( $this->getController()->getMode() ),
                $this->getController()->getControllerName() == "home" );

        // Facilities
        $this->getControllerMenuPresenter()->addItem( "Facilities",
                Resource::url()->campusguide()->cms()->facility()->getController( $this->getController()->getMode() ),
                $this->getController()->getControllerName() == FacilitiesCmsCampusguideMainController::$CONTROLLER_NAME );

        // Buildings
        $this->getControllerMenuPresenter()->addItem( "Buildings",
                Resource::url()->campusguide()->cms()->building()->getController( $this->getController()->getMode() ),
                $this->getController()->getControllerName() == BuildingsCmsCampusguideMainController::$CONTROLLER_NAME );

    }

    // ... /DO


    // ... DRAW


    /**
     * @see View::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_CMS_WRAPPER );

        // Draw controller header
        $this->drawControllerHeader( $wrapper );

        // ... MAIN


        // Create wrapper
        $mainWrapper = Xhtml::div()->id( $this->getWrapperId() );

        // Draw header
        $mainWrapperHeader = Xhtml::div()->id( self::$ID_HEADER_WRAPPER );
        $this->drawPageHeader( $mainWrapperHeader );
        $mainWrapper->addContent( $mainWrapperHeader );

        // Draw menu
        $this->getPageMenuPresenter()->draw( $mainWrapper );

        // Draw error
        $this->drawPageError( $mainWrapper );

        // Draw page
        $this->drawPage( $mainWrapper );

        // Add main to wrapper
        $wrapper->addContent( Xhtml::div( $mainWrapper )->id( self::$ID_CMS_MAIN_WRAPPER ) );

        // ... /MAIN


        // ... OVERLAY


        // Draw overlay
        $this->getOverlayPresenter()->setId( self::$ID_OVERLAY );
        $this->getOverlayPresenter()->setTitle( "Title" );
        $this->getOverlayPresenter()->setBody( "Body" );
        $this->getOverlayPresenter()->draw( $wrapper );

        // ... /OVERLAY


        // ... QUEUE


        if ( $this->getController()->getQueue() )
        {
            $this->getQueuePresenter()->draw( $wrapper );
        }

        // ... QUEUE


        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... .... CONTROLLER


    /**
     * @param AbstractXhtml overlayWrapper
     */
    private function drawControllerHeader( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( "controller_header_wrapper" );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // Create header
        $header = Xhtml::h( 1, "Campusguide" );
        $headerUnder = Xhtml::div( "CMS" );
        $table->addContent( Xhtml::div( $header )->addContent( $headerUnder )->id( "header_wrapper" ) );

        // Draw menu
        $tableCell = Xhtml::div();
        $this->getControllerMenuPresenter()->draw( $tableCell );
        $table->addContent( $tableCell );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // ... ... /CONTROLLER


    // ... ... PAGE


    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawPage( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawPageHeader( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected function drawPageError( AbstractXhtml $root )
    {

        // Foreach errors
        foreach ( $this->getController()->getErrors() as $error )
        {
            if ( get_class( $error ) == BadrequestException::class_() )
            {
                $this->getErrorPresenter()->setError( $error );
                $this->getErrorPresenter()->draw( $root );
            }
        }

    }

    // ... ... /PAGE


    // ... /DRAW


    // /FUNCTIONS


}

?>