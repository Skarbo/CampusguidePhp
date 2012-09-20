<?php

class DeleteFacilityFacilitiesCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    private static $ID_DELETE_FACILITY_PAGE_WRAPPER = "delete_facility_page_wrapper";

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

    /**
     * @return FacilityListModel
     */
    private function getFacilities()
    {
        return $this->getView()->getController()->getFacilities();
    }

    // ... /GET


    /**
     * @see FacilityFacilitiesCmsCampusguidePageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Page wrapper
        $pageWrapper = Xhtml::div()->id( self::$ID_DELETE_FACILITY_PAGE_WRAPPER );

        // Add header to wrapper
        $pageWrapper->addContent(
                Xhtml::div(
                        Xhtml::h( 2,
                                $this->getLocale()->facility()->getDeletingFacility( $this->getFacilities()->size() ) ) )->class_(
                        Resource::css()->campusguide()->cms()->page()->getHeaderWrapper() ) );

        // Add body
        $pageWrapper->addContent(
                Xhtml::div( $this->getLocale()->facility()->getDeletingFacilitySure( $this->getFacilities()->size() ) ) );

        // Cancel/Delete buttons
        $buttonsGui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui(), "theme2" );

        // Delete button
        $buttonsGui->addContent(
                Xhtml::a( "Cancel" )->title( "Cancel" )->href( "javascript: history.back(-1);" )->addClass(
                        Resource::css()->gui()->getComponent() )->attr( "data-type", "button_icon" )->attr( "data-icon",
                        "cross" )->attr( "data-icon-placing", "right" ) );

        // Edit button
        $buttonsGui->addContent(
                Xhtml::a( "Confirm" )->title( "Confirm" )->href(
                        sprintf( "javascript: Core.postToUrl('%s');",
                                Resource::url()->campusguide()->cms()->facility()->getDeleteFacilityPage(
                                        $this->getFacilities()->getIds(), $this->getView()->getController()->getMode() ) ) )->addClass(
                        Resource::css()->gui()->getComponent() )->attr( "data-type", "button_icon" )->attr( "data-icon",
                        "check" )->attr( "data-icon-placing", "right" ) );

        // Add button gui to wrapper
        $pageWrapper->addContent( $buttonsGui );

        // Add page wrapper to root
        $root->addContent( $pageWrapper );

    }

    // /FUNCTIONS


}

?>