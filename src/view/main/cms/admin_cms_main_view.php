<?php

class AdminCmsMainView extends CmsMainView implements ErrorsAdminCmsInterfaceView, QueueAdminCmsInterfaceView
{

    // VARIABLES


    private static $ID_ADMIN_CMS_WRAPPER = "admin_cms_wrapper";

    /**
     * @var ErrorsAdminCmsPageMainView
     */
    private $errorsPage;
    /**
     * @var QueueAdminCmsPageMainView
     */
    private $queuePage;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        $this->errorsPage = new ErrorsAdminCmsPageMainView( $this );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see CmsMainView::getController()
     * @return AdminCmsMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    protected function getWrapperId()
    {
        return self::$ID_ADMIN_CMS_WRAPPER;
    }

    /**
     * @return ErrorsAdminCmsPageMainView
     */
    private function getErrorsPage()
    {
        return $this->errorsPage;
    }

    /**
     * @return QueueAdminCmsPageMainView
     */
    private function getQueuePage()
    {
        return $this->queuePage;
    }

    /**
     * @see ErrorsAdminCmsInterfaceView::getErrors()
     */
    public function getErrors()
    {
        return $this->getController()->getErrors();
    }

    /**
     * @see QueueAdminCmsInterfaceView::getQueues()
     */
    public function getQueues()
    {
        return $this->getController()->getQueues();
    }

    /**
     * @see QueueAdminCmsInterfaceView::getWebsites()
     */
    public function getWebsites()
    {
        return $this->getController()->getWebsites();
    }

    /**
     * @see QueueAdminCmsInterfaceView::getFacilities()
     */
    public function getFacilities()
    {
        return $this->getController()->getFacilities();
    }

    // ... /GET


    /**
     * @see CmsMainView::before()
     */
    public function before()
    {
        parent::before();
        $this->queuePage = new QueueAdminCmsPageMainView( $this );
    }

    /**
     * @see CmsMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->cms()->admin()->getOverviewPage( $this->getMode() ),
                $this->getController()->isPageOverview() );

        // Queues
        $this->getPageMenuPresenter()->addItem( "Queue",
                Resource::url()->cms()->admin()->getQueuePage( $this->getMode() ), $this->getController()->isPageQueue() );

        // Errors
        $this->getPageMenuPresenter()->addItem( "Errors",
                Resource::url()->cms()->admin()->getErrorsPage( $this->getMode() ),
                $this->getController()->isPageErrors() );

        // New Queue
        if ( $this->getController()->isPageQueue() )
        {
            $this->getPageMenuPresenter()->addItem( "New",
                    Resource::url()->cms()->admin()->getQueuePageNew( $this->getMode() ),
                    $this->getController()->isActionNew(), ItemPageMenuCmsPresenterView::ALIGN_RIGHT );
        }

    }

    /**
     * @see CmsMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {
        if ( $this->getController()->isPageErrors() )
        {
            $this->getErrorsPage()->draw( $root );
        }
        elseif ( $this->getController()->isPageQueue() )
        {
            $this->getQueuePage()->draw( $root );
        }
    }

    /**
     * @see CmsMainView::drawPageHeader()
     */
    protected function drawPageHeader( AbstractXhtml $root )
    {
        $root->addContent( Xhtml::h( 1, "Administration" ) );
    }

    // /FUNCTIONS


}

?>