<?php

class FacilitiesCmsMainView extends CmsMainView
{

    // VARIABLES


    public static $ID_CMS_FACILITIES_WRAPPER = "facilities_cms_wrapper";

    /**
     * @var OverviewFacilitiesCmsPageMainView
     */
    private $overviewFacilitiesPage;
    /**
     * @var FacilityFacilitiesCmsPageMainView
     */
    private $facilityFacilitiesPage;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverviewFacilitiesCmsPageMainView
     */
    public function getOverviewFacilitiesPage()
    {
        return $this->overviewFacilitiesPage;
    }

    /**
     * @param OverviewFacilitiesCmsPageMainView $overviewFacilitiesPageMain
     */
    public function setOverviewFacilitiesPage( OverviewFacilitiesCmsPageMainView $overviewFacilitiesPageMain )
    {
        $this->overviewFacilitiesPage = $overviewFacilitiesPageMain;
    }

    /**
     * @return FacilityFacilitiesCmsPageMainView
     */
    public function getFacilityFacilitiesPage()
    {
        return $this->facilityFacilitiesPage;
    }

    /**
     * @param FacilityFacilitiesCmsPageMainView $facilityFacilitiesPage
     */
    public function setFacilityFacilitiesPage( FacilityFacilitiesCmsPageMainView $facilityFacilitiesPage )
    {
        $this->facilityFacilitiesPage = $facilityFacilitiesPage;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return FacilitiesCmsMainController
     * @see AbstractView::getController()
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see CmsMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_CMS_FACILITIES_WRAPPER;
    }

    // ... /GET


    /**
     * @see AbstractView::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverviewFacilitiesPage( new OverviewFacilitiesCmsPageMainView( $this ) );
        $this->setFacilityFacilitiesPage( new FacilityFacilitiesCmsPageMainView( $this ) );
    }

    // ... DO


    /**
     * @see CmsMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->cms()->facility()->getOverviewPage( $this->getController()->getMode() ),
                $this->getController()->isPageOverview() );

        // Map
        $this->getPageMenuPresenter()->addItem( "Map",
                Resource::url()->cms()->facility()->getMapPage( $this->getController()->getMode() ),
                $this->getController()->isPageMap() );

        //  New
        $this->getPageMenuPresenter()->addItem( "New",
                Resource::url()->cms()->facility()->getNewFacilityPage(
                        $this->getController()->getMode() ),
                $this->getController()->isPageFacility() && $this->getController()->isActionNew(),
                ItemPageMenuCmsPresenterView::ALIGN_RIGHT );

    }

    // ... /DO


    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Overview page
        if ( $this->getController()->isPageOverview() )
        {
            $this->getOverviewFacilitiesPage()->draw( $root );
        }
        // Facilities page
        else if ( $this->getController()->isPageFacility() )
        {
            $this->getFacilityFacilitiesPage()->draw( $root );
        }

    }

    /**
     * @see CmsMainView::drawPageHeader()
     */
    protected function drawPageHeader( AbstractXhtml $root )
    {

        // Add header to root
        $root->addContent( Xhtml::h( 1, "Facilities" ) );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>