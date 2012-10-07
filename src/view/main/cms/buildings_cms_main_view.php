<?php

class BuildingsCmsMainView extends CmsMainView implements BuildingsCmsInterfaceView, BuildingcreatorBuildingsCmsInterfaceView
{

    // VARIABLES


    public static $ID_CMS_BUILDINGS_WRAPPER = "buildings_cms_wrapper";

    /**
     * @var OverviewBuildingsCmsPageMainView
     */
    private $overviewPage;
    /**
     * @var BuildingBuildingsCmsPageMainView
     */
    private $buildingPage;
    /**
     * @var BuildingcreatorBuildingsCmsPageMainView
     */
    private $buildingcreatorPage;
    /**
     * @var FloorplannerBuildingsCmsPageMainView
     */
    private $floorplannerPage;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return OverviewBuildingsCmsPageMainView
     */
    public function getOverviewPage()
    {
        return $this->overviewPage;
    }

    /**
     * @param OverviewBuildingsCmsPageMainView $overviewPage
     */
    public function setOverviewPage( OverviewBuildingsCmsPageMainView $overviewPage )
    {
        $this->overviewPage = $overviewPage;
    }

    /**
     * @return BuildingBuildingsCmsPageMainView
     */
    public function getBuildingPage()
    {
        return $this->buildingPage;
    }

    /**
     * @param BuildingBuildingsCmsPageMainView $buildingPage
     */
    public function setBuildingPage( BuildingBuildingsCmsPageMainView $buildingPage )
    {
        $this->buildingPage = $buildingPage;
    }

    /**
     * @return BuildingcreatorBuildingsCmsPageMainView
     */
    public function getBuildingcreatorPage()
    {
        return $this->buildingcreatorPage;
    }

    /**
     * @param BuildingcreatorBuildingsCmsPageMainView $buildingcreatorPage
     */
    public function setBuildingcreatorPage( BuildingcreatorBuildingsCmsPageMainView $buildingcreatorPage )
    {
        $this->buildingcreatorPage = $buildingcreatorPage;
    }

    /**
     * @return FloorplannerBuildingsCmsPageMainView
     */
    public function getFloorplannerPage()
    {
        return $this->floorplannerPage;
    }

    /**
     * @param FloorplannerBuildingsCmsPageMainView $floorplannerPage
     */
    public function setFloorplannerPage( FloorplannerBuildingsCmsPageMainView $floorplannerPage )
    {
        $this->floorplannerPage = $floorplannerPage;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return BuildingsCmsMainController
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
        return self::$ID_CMS_BUILDINGS_WRAPPER;
    }

    /**
     * @see BuildingsCmsInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getController()->getBuilding();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingFloors()
     */
    public function getBuildingFloors()
    {
        return $this->getController()->getBuildingFloors();
    }

    /**
     * @see BuildingcreatorBuildingsCmsInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->getController()->getBuildingElements();
    }

    // ... /GET


    // ... DO


    /**
     * @see CmsMainView::doPageMenu()
     */
    protected function doPageMenu()
    {

        // Overview
        $this->getPageMenuPresenter()->addItem( "Overview",
                Resource::url()->cms()->building()->getOverviewPage( $this->getMode() ),
                $this->getController()->isPageOverview() );

        // Building Creator
        $this->getPageMenuPresenter()->addItem( "Building Creator",
                Resource::url()->cms()->building()->getBuildingcreatorPage( "", $this->getMode() ),
                $this->getController()->isPageBuildingcreator() );

        // Floor Planner
        $this->getPageMenuPresenter()->addItem( "Floor Planner",
                Resource::url()->cms()->building()->getFloorplannerPage( $this->getMode() ),
                $this->getController()->isPageFloorplanner() );

        // New Building
        $this->getPageMenuPresenter()->addItem( "New",
                Resource::url()->cms()->building()->getNewBuildingPage( $this->getMode() ),
                $this->getController()->isPageBuilding() && $this->getController()->isActionNew(),
                ItemPageMenuCmsPresenterView::ALIGN_RIGHT );

    }

    // ... /DO


    /**
     * @see AbstractView::before()
     */
    public function before()
    {
        parent::before();
        $this->setOverviewPage( new OverviewBuildingsCmsPageMainView( $this ) );
        $this->setBuildingPage( new BuildingBuildingsCmsPageMainView( $this ) );
        $this->setBuildingcreatorPage( new BuildingcreatorBuildingsCmsPageMainView( $this ) );
        $this->setFloorplannerPage( new FloorplannerBuildingsCmsPageMainView( $this ) );
    }

    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Overview page
        if ( $this->getController()->isPageOverview() )
        {
            $this->getOverviewPage()->draw( $root );
        }
        // Building page
        else if ( $this->getController()->isPageBuilding() )
        {
            $this->getBuildingPage()->draw( $root );
        }
        // Buildingcreator page
        else if ( $this->getController()->isPageBuildingcreator() )
        {
            $this->getBuildingcreatorPage()->draw( $root );
        }
        // Floorplanner page
        else if ( $this->getController()->isPageFloorplanner() )
        {
            $this->getFloorplannerPage()->draw( $root );
        }

    }

    /**
     * @see CmsMainView::drawPageHeader()
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