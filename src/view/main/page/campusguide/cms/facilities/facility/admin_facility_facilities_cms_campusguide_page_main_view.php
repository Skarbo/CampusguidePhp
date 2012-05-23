<?php

class AdminFacilityFacilitiesCmsCampusguidePageMainView extends AdminCmsCampusguidePageMainView
{

    // VARIABLES


    private static $ID_ADMIN_FACILITY_PAGE_WRAPPER = "admin_facility_page_wrapper";
    private static $ID_FIELDS_WRAPPER = "fields_wrapper";
    private static $ID_FACILITY_FORM = "facility_form";

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

    private function getHeaderText()
    {
        return $this->isActionEdit() ? sprintf( "Edit Facility: %s", $this->getFacilityAdmin()->getName() ) : "New Facility";
    }

    private function getFormAction()
    {
        return $this->isActionEdit() ? Resource::url()->campusguide()->cms()->facility()->getEditFacilityPage(
                $this->getFacility()->getId(), $this->getView()->getController()->getMode() ) : Resource::url()->campusguide()->cms()->facility()->getNewFacilityPage(
                $this->getView()->getController()->getMode() );
    }

    private function getFacility()
    {
        return $this->getView()->getController()->getFacility();
    }

    private function getFacilityAdmin()
    {
        return $this->getView()->getController()->getFacilityAdmin();
    }

    /**
     * @see PageCmsCampusguidePageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_ADMIN_FACILITY_PAGE_WRAPPER;
    }

    // ... /GET


    // ... DRAW


    /**
     * @see PageCmsCampusguidePageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {

        // Create Header
        $header = Xhtml::h( 2 );

        if ( $this->isActionEdit() )
        {
            $header->addContent( "Edit Facility: " );
            $header->addContent(
                    Xhtml::a( $this->getFacility()->getName() )->href(
                            Resource::url()->campusguide()->cms()->facility()->getViewFacilityPage(
                                    $this->getFacility()->getId(), $this->getMode() ) ) );
        }
        else
        {
            $header->addContent( "New Facility" );
        }

        // Add header to root
        $root->addContent( $header );

    }

    /**
     * @see PageCmsCampusguidePageMainView::drawBody()
     */
    public function drawBody( AbstractXhtml $root )
    {

        // Create fields wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->getFieldsWrapper() );

        // Add fields to wrapper
        $this->drawFields( $wrapper );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml table
     */
    private function drawFields( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->getFields() );

        // Create Facility name field
        $field = Xhtml::div();

        $field->addContent( Xhtml::div( "Name" )->class_( Resource::css()->campusguide()->cms()->getRequired() ) );

        $field->addContent(
                Xhtml::div(
                        Xhtml::input( $this->getFacilityAdmin()->getName(), "name" )->id(
                                Resource::db()->facility()->getFieldName() ) )->class_( Resource::css()->getNopadding() ) );

        $table->addContent( $field );

        // Create cancel/save field
        $buttons = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );
        $buttons->addContent(
                Xhtml::a( "Cancel" )->href( "javascript:history.back(-1)" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "cross" )->attr( "data-icon-placing", "right" ) );
        $buttons->addContent(
                Xhtml::button( "Save" )->type( ButtonXhtml::$TYPE_SUBMIT )->id( "facility_save" )->class_(
                        Resource::css()->gui()->getButton(), Resource::css()->gui()->getComponent() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "check" )->attr( "data-icon-placing", "right" )->onclick(
                        sprintf( "javascript: $('#%s').submit();", self::$ID_FACILITY_FORM ) ) );

        $field = Xhtml::div();

        $field->addContent( Xhtml::div( Xhtml::$NBSP ) );

        $field->addContent( Xhtml::div( $buttons )->class_( Resource::css()->getRight() ) );

        $table->addContent( $field );

        // Create form
        $form = Xhtml::form()->action( $this->getFormAction() )->method( FormXhtml::$METHOD_POST )->id(
                self::$ID_FACILITY_FORM );

        // Add table to form
        $form->addContent( $table );

        // Add form to table
        $root->addContent( $form );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>