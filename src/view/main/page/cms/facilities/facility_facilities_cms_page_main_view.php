<?php

class FacilityFacilitiesCmsPageMainView extends AbstractPageMainView
{

    // VARIABLES


    private static $ID_FACILITY_PAGE_WRAPPER = "facility_page_wrapper";

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

        $adminFacilityPage = new AdminFacilityFacilitiesCmsPageMainView( $this->getView() );
        $viewFacilityPage = new ViewFacilityFacilitiesCmsPageMainView( $this->getView() );
        $deleteFacilityPage = new DeleteFacilityFacilitiesCmsPageMainView( $this->getView() );

        // Create page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_FACILITY_PAGE_WRAPPER );

        // Action new/edit
        if ( $this->getView()->getController()->isActionNew() || $this->getView()->getController()->isActionEdit() )
        {
            $adminFacilityPage->draw( $pageWrapper );
        }
        // Action view
        elseif ( $this->getView()->getController()->isActionView() )
        {
            $viewFacilityPage->draw( $pageWrapper );
        }
        // Delete view
        elseif ( $this->getView()->getController()->isActionDelete() )
        {
            $deleteFacilityPage->draw( $pageWrapper );
        }

        // Add page wrapper to root
        $root->addContent( $pageWrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>