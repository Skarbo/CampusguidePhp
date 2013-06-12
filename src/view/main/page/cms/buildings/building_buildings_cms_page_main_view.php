<?php

class BuildingBuildingsCmsPageMainView extends AbstractPageMainView
{

    // VARIABLES


    private static $ID_BUILDING_WRAPPER = "building_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPageMainView::getView()
     * @return BuildingsCmsMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see AbstractPageMainView::getController()
     * @return BuildingsCmsMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AbstractPageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        $adminFacilityPage = new AdminBuildingBuildingsCmsPageMainView( $this->getView() );
        $deleteBuildingPage = new DeleteBuildingBuildingsCmsPageMainView( $this->getView() );
        $viewBuildingPage = new ViewBuildingBuildingsCmsPageMainView( $this->getView() );

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_BUILDING_WRAPPER );

        // Action new/edit
        if ( $this->getController()->isActionNew() || $this->getController()->isActionEdit() )
        {
            $adminFacilityPage->draw( $pageWrapper );
        }
        // Action delete
        else if ( $this->getController()->isActionDelete() )
        {
            $deleteBuildingPage->draw( $pageWrapper );
        }
        // Action View
        else
        {
            $viewBuildingPage->draw( $pageWrapper );
        }

        // Add page wrapper to root
        $root->addContent( $pageWrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>