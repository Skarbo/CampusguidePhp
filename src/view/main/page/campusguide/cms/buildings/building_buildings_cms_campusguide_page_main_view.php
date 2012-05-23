<?php

class BuildingBuildingsCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    private static $ID_BUILDING_WRAPPER = "building_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PageMainView::getView()
     * @return FacilitiesCmsCampusguideMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        $adminFacilityPage = new AdminBuildingBuildingsCmsCampusguidePageMainView( $this->getView() );

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