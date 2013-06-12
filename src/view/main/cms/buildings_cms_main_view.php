<?php

class BuildingsCmsMainView extends CmsMainView implements BuildingsCmsInterfaceView
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

        if ( $this->getBuilding() )
        {

            // Overview
            $this->getPageMenuPresenter()->addItem( "Building",
                    Resource::url()->cms()->buildings()->building()->getViewAction( $this->getBuilding()->getId(),
                            $this->getMode() ),
                    $this->getController()->isPageBuilding() && $this->getController()->isActionView() );

            // Building Creator
            $this->getPageMenuPresenter()->addItem( "Building Creator",
                    Resource::url()->cms()->buildings()->buildingcreator()->getViewAction(
                            $this->getBuilding()->getId(), $this->getMode() ),
                    $this->getController()->isPageBuildingcreator() );

            // Edit Building
            $this->getPageMenuPresenter()->addItem( "Edit",
                    Resource::url()->cms()->buildings()->getEditBuildingPage( $this->getBuilding()->getId(),
                            $this->getMode() ), $this->isActionEdit(), ItemPageMenuCmsPresenterView::ALIGN_RIGHT );

        }
        else
        {

            // Overview
            $this->getPageMenuPresenter()->addItem( "Overview",
                    Resource::url()->cms()->buildings()->getOverviewPage( $this->getMode() ),
                    $this->getController()->isPageOverview() );

        }

        // New Building
        $this->getPageMenuPresenter()->addItem( "New",
                Resource::url()->cms()->buildings()->getNewBuildingPage( $this->getMode() ),
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

        // Navigation
        if ( $this->getBuilding() )
        {
            $this->addNavigation( "Buildings",
                    Resource::url()->cms()->buildings()->getOverviewPage( $this->getMode() ) );
        }
    }

    // ... DRAW


    /**
     * @see CmsMainView::drawPageHeader()
     */
    protected function drawPageHeader( AbstractXhtml $root )
    {

        if ( $this->getBuilding() )
        {
            $root->addContent(
                    Xhtml::h( 1, sprintf( "Building: %s", Xhtml::span( $this->getBuilding()->getName() ) ) ) );
        }
        else
        {
            $root->addContent( Xhtml::h( 1, "Buildings" ) );
        }

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Building page
        if ( $this->getController()->isPageBuilding() )
        {
            $this->getBuildingPage()->draw( $root );
        }
        // Buildingcreator page
        else if ( $this->getController()->isPageBuildingcreator() )
        {
            $this->getBuildingcreatorPage()->draw( $root );
        }
        // Overview page
        else
        {
            $this->getOverviewPage()->draw( $root );
        }

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>