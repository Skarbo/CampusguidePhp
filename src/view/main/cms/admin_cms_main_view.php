<?php

class AdminCmsMainView extends CmsMainView implements ErrorsAdminCmsInterfaceView
{

    // VARIABLES


    private static $ID_ADMIN_CMS_WRAPPER = "admin_cms_wrapper";

    /**
     * @var ErrorsAdminCmsPageMainView
     */
    private $errorsPage;

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
     * @see ErrorsAdminCmsInterfaceView::getErrors()
     */
    public function getErrors()
    {
        return $this->getController()->getErrors();
    }

    // ... /GET

    /**
     * @see CmsMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->cms()->admin()->getOverviewPage( $this->getMode() ),
                $this->getController()->isPageOverview() );

        // Errors
        $this->getPageMenuPresenter()->addItem( "Errors",
                Resource::url()->cms()->admin()->getErrorsPage( $this->getMode() ),
                $this->getController()->isPageErrors() );

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