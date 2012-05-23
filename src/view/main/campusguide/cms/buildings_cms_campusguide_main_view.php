<?php

class BuildingsCmsCampusguideMainView extends CmsCampusguideMainView
{

    // VARIABLES


    public static $ID_CMS_BUILDINGS_WRAPPER = "buildings_cms_wrapper";

    /**
     * @var OverviewBuildingsCmsCampusguidePageMainView
     */
    private $overviewPage;
    /**
     * @var BuildingBuildingsCmsCampusguidePageMainView
     */
    private $buildingPage;
    /**
     * @var FloorplannerBuildingsCmsCampusguidePageMainView
     */
    private $floorplannerPage;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverviewBuildingsCmsCampusguidePageMainView
     */
    public function getOverviewPage()
    {
        return $this->overviewPage;
    }

    /**
     * @param OverviewBuildingsCmsCampusguidePageMainView $overviewPage
     */
    public function setOverviewPage( OverviewBuildingsCmsCampusguidePageMainView $overviewPage )
    {
        $this->overviewPage = $overviewPage;
    }

    /**
     * @return BuildingBuildingsCmsCampusguidePageMainView
     */
    public function getBuildingPage()
    {
        return $this->buildingPage;
    }

    /**
     * @param BuildingBuildingsCmsCampusguidePageMainView $buildingPage
     */
    public function setBuildingPage( BuildingBuildingsCmsCampusguidePageMainView $buildingPage )
    {
        $this->buildingPage = $buildingPage;
    }

    /**
     * @return FloorplannerBuildingsCmsCampusguidePageMainView
     */
    public function getFloorplannerPage()
    {
        return $this->floorplannerPage;
    }

    /**
     * @param FloorplannerBuildingsCmsCampusguidePageMainView $floorplannerPage
     */
    public function setFloorplannerPage( FloorplannerBuildingsCmsCampusguidePageMainView $floorplannerPage )
    {
        $this->floorplannerPage = $floorplannerPage;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return BuildingsCmsCampusguideMainController
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
        return self::$ID_CMS_BUILDINGS_WRAPPER;
    }

    // ... /GET


    // ... DO


    /**
     * @see CmsCampusguideMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->campusguide()->cms()->building()->getOverviewPage( $this->getController()->getMode() ),
                $this->getController()->isPageOverview() );

        // Floor Planner
        $this->getPageMenuPresenter()->addItem( "Floor Planner",
                Resource::url()->campusguide()->cms()->building()->getFloorplannerPage(
                        $this->getController()->getMode() ), $this->getController()->isPageFloorplanner() );

        // New Building
        $this->getPageMenuPresenter()->addItem( "New",
                Resource::url()->campusguide()->cms()->building()->getNewBuildingPage(
                        $this->getController()->getMode() ),
                $this->getController()->isPageBuilding() && $this->getController()->isActionNew(),
                ItemPageMenuCmsCampusguidePresenterView::ALIGN_RIGHT );

    }

    // ... /DO


    /**
     * @see View::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverviewPage( new OverviewBuildingsCmsCampusguidePageMainView( $this ) );
        $this->setBuildingPage( new BuildingBuildingsCmsCampusguidePageMainView( $this ) );
        $this->setFloorplannerPage( new FloorplannerBuildingsCmsCampusguidePageMainView( $this ) );
    }

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
            $this->getOverviewPage()->draw( $wrapper );
        }
        // Building page
        else if ( $this->getController()->isPageBuilding() )
        {
            $this->getBuildingPage()->draw( $wrapper );
        }
        // Floorplanner page
        else if ( $this->getController()->isPageFloorplanner() )
        {
            $this->getFloorplannerPage()->draw( $wrapper );
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
        $root->addContent( Xhtml::h( 1, "Buildings" ) );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>