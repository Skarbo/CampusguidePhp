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
     * @return FacilitiesCmsMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AbstractPageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        $adminFacilityPage = new AdminBuildingBuildingsCmsPageMainView( $this->getView() );

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_BUILDING_WRAPPER );

        // Action new/edit
        if ( $this->getView()->getController()->isActionNew() || $this->getView()->getController()->isActionEdit() )
        {
            $adminFacilityPage->draw( $pageWrapper );
        }

        // Add page wrapper to root
        $root->addContent( $pageWrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>