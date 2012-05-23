<?php

class FacilitiesCmsCampusguideMainView extends CmsCampusguideMainView
{

    // VARIABLES


    public static $ID_CMS_FACILITIES_WRAPPER = "facilities_cms_wrapper";

    /**
     * @var OverviewFacilitiesCmsCampusguidePageMainView
     */
    private $overviewFacilitiesPage;
    /**
     * @var FacilityFacilitiesCmsCampusguidePageMainView
     */
    private $facilityFacilitiesPage;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverviewFacilitiesCmsCampusguidePageMainView
     */
    public function getOverviewFacilitiesPage()
    {
        return $this->overviewFacilitiesPage;
    }

    /**
     * @param OverviewFacilitiesCmsCampusguidePageMainView $overviewFacilitiesPageMain
     */
    public function setOverviewFacilitiesPage( OverviewFacilitiesCmsCampusguidePageMainView $overviewFacilitiesPageMain )
    {
        $this->overviewFacilitiesPage = $overviewFacilitiesPageMain;
    }

    /**
     * @return FacilityFacilitiesCmsCampusguidePageMainView
     */
    public function getFacilityFacilitiesPage()
    {
        return $this->facilityFacilitiesPage;
    }

    /**
     * @param FacilityFacilitiesCmsCampusguidePageMainView $facilityFacilitiesPage
     */
    public function setFacilityFacilitiesPage( FacilityFacilitiesCmsCampusguidePageMainView $facilityFacilitiesPage )
    {
        $this->facilityFacilitiesPage = $facilityFacilitiesPage;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return FacilitiesCmsCampusguideMainController
     * @see View::getController()
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see CmsCampusguideMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_CMS_FACILITIES_WRAPPER;
    }

    // ... /GET


    /**
     * @see View::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverviewFacilitiesPage( new OverviewFacilitiesCmsCampusguidePageMainView( $this ) );
        $this->setFacilityFacilitiesPage( new FacilityFacilitiesCmsCampusguidePageMainView( $this ) );
    }

    // ... DO


    /**
     * @see CmsCampusguideMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->campusguide()->cms()->facility()->getOverviewPage( $this->getController()->getMode() ),
                $this->getController()->isPageOverview() );

        // Map
        $this->getPageMenuPresenter()->addItem( "Map",
                Resource::url()->campusguide()->cms()->facility()->getMapPage( $this->getController()->getMode() ),
                $this->getController()->isPageMap() );

        //  New
        $this->getPageMenuPresenter()->addItem( "New",
                Resource::url()->campusguide()->cms()->facility()->getNewFacilityPage(
                        $this->getController()->getMode() ),
                $this->getController()->isPageFacility() && $this->getController()->isActionNew(),
                ItemPageMenuCmsCampusguidePresenterView::ALIGN_RIGHT );

    }

    // ... /DO


    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( PageMainView::$ID_PAGE_WRAPPER );

        // Overview page
        if ( $this->getController()->isPageOverview() )
        {
            $this->getOverviewFacilitiesPage()->draw( $wrapper );
        }
        // Facilities page
        else if ( $this->getController()->isPageFacility() )
        {
            $this->getFacilityFacilitiesPage()->draw( $wrapper );
        }

        // Add wrappe to root
        $root->addContent( $wrapper );

    }

    /**
     * @see CmsCampusguideMainView::drawPageHeader()
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