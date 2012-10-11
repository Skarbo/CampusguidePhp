<?php

abstract class CmsMainView extends AbstractMainView
{

    // VARIABLES


    public static $ID_CMS_WRAPPER = "cms_wrapper";
    public static $ID_CMS_MAIN_WRAPPER = "main_cms_wrapper";
    public static $ID_HEADER_WRAPPER = "header_wrapper";
    public static $ID_OVERLAY = "overlay";

    /**
     * @var PageMenuCmsPresenterView
     */
    private $pageMenuPresenter;
    /**
     * @var ControllerMenuCmsPresenterView
     */
    private $controllerMenuPresenter;

    /**
     * @var ErrorCmsPresenterView
     */
    private $errorPresenter;
    /**
     * @var OverlayCmsPresenterView
     */
    private $overlayPresenter;
    /**
     * @var QueueCmsPresenterView
     */
    private $queuePresenter;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return PageMenuCmsPresenterView
     */
    protected function getPageMenuPresenter()
    {
        return $this->pageMenuPresenter;
    }

    /**
     * @param PageMenuCmsPresenterView $menuPresenter
     */
    protected function setPageMenuPresenter( PagePageMenuCmsPresenterView $menuPresenter )
    {
        $this->pageMenuPresenter = $menuPresenter;
    }

    /**
     * @return ControllerMenuCmsPresenterView
     */
    private function getControllerMenuPresenter()
    {
        return $this->controllerMenuPresenter;
    }

    /**
     * @param ControllerMenuCmsPresenterView $controllerMenuPresenter
     */
    private function setControllerMenuPresenter( ControllerMenuCmsPresenterView $controllerMenuPresenter )
    {
        $this->controllerMenuPresenter = $controllerMenuPresenter;
    }

    /**
     * @return ErrorCmsPresenterView
     */
    public function getErrorPresenter()
    {
        return $this->errorPresenter;
    }

    /**
     * @param ErrorCmsPresenterView $errorPresenter
     */
    public function setErrorPresenter( ErrorCmsPresenterView $errorPresenter )
    {
        $this->errorPresenter = $errorPresenter;
    }

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

    /**
     * @return QueueCmsPresenterView
     */
    public function getQueuePresenter()
    {
        return $this->queuePresenter;
    }

    /**
     * @param QueueCmsPresenterView $canvasPresenter
     */
    public function setQueuePresenter( QueueCmsPresenterView $canvasPresenter )
    {
        $this->queuePresenter = $canvasPresenter;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return CmsMainController
     * @see AbstractView::getController()
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

    /**
     * @return boolean
     */
    public function isActionNew()
    {
        return $this->getController()->isActionNew();
    }

    /**
     * @return boolean
     */
    public function isActionEdit()
    {
        return $this->getController()->isActionEdit();
    }

    /**
     * @return boolean
     */
    public function isActionView()
    {
        return $this->getController()->isActionView();
    }

    /**
     * @return boolean
     */
    public function isActionDelete()
    {
        return $this->getController()->isActionDelete();
    }

    // ... /IS


    /**
     * @see AbstractView::before()
     */
    public function before()
    {
        $this->setPageMenuPresenter( new PageMenuCmsPresenterView( $this ) );
        $this->setControllerMenuPresenter( new ControllerMenuCmsPresenterView( $this ) );
        $this->setErrorPresenter( new ErrorCmsPresenterView( $this ) );
        $this->setOverlayPresenter( new OverlayCmsPresenterView( $this ) );

        // ... Queue
        if ( $this->getController()->getQueue() )
        {
            $this->setQueuePresenter( new QueueCmsPresenterView( $this, $this->getController()->getQueue() ) );
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
                Resource::url()->cms()->getHome( $this->getMode() ),
                $this->getController()->getControllerName() == "home" );

        // Facilities
        $this->getControllerMenuPresenter()->addItem( "Facilities",
                Resource::url()->cms()->facility()->getController( $this->getMode() ),
                $this->getController()->getControllerName() == FacilitiesCmsMainController::$CONTROLLER_NAME );

        // Buildings
        $this->getControllerMenuPresenter()->addItem( "Buildings",
                Resource::url()->cms()->building()->getController( $this->getMode() ),
                $this->getController()->getControllerName() == BuildingsCmsMainController::$CONTROLLER_NAME );

        // Admin
        $this->getControllerMenuPresenter()->addItem( "Administration",
                Resource::url()->cms()->admin()->getOverviewPage( $this->getMode() ),
                $this->getController()->getControllerName() == AdminCmsMainController::$CONTROLLER_NAME );

    }

    // ... /DO


    // ... DRAW


    /**
     * @see AbstractView::draw()
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
        $pageWrapper = Xhtml::div()->id( AbstractPageMainView::$ID_PAGE_WRAPPER );
        $this->drawPage( $pageWrapper );
        $mainWrapper->addContent( $pageWrapper );

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