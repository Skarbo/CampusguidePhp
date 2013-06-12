<?php

class DeleteBuildingBuildingsCmsPageMainView extends PageCmsPageMainView implements DeleteBuildingBuildingsCmsInterfaceView
{

    // VARIABLES


    private static $WRAPPER_ID = "delete_building_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PageCmsPageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$WRAPPER_ID;
    }

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

    /**
     * @see DeleteBuildingBuildingsCmsInterfaceView::getBuildings()
     */
    public function getBuildings()
    {
        return $this->getController()->getBuildings();
    }

    // ... /GET


    /**
     * @see PageCmsPageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        $root->addContent( Xhtml::h( 2, $this->getLocale()->building()->getDeletingBuilding( $this->getBuildings()->size() ) ) );
    }

    /**
     * @see PageCmsPageMainView::drawBody()
     */
    protected function drawBody( AbstractXhtml $root )
    {

        $root->addContent(
                Xhtml::div( $this->getLocale()->building()->getDeletingBuildingSure( $this->getBuildings()->size() ) ) );

        // Cancel/Delete buttons
        $buttonsGui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui(), "theme2" );

        // Cancel button
        $buttonsGui->addContent(
                Xhtml::a( "Cancel" )->title( "Cancel" )->href( "javascript: history.back(-1);" )->addClass(
                        Resource::css()->gui()->getComponent() )->attr( "data-type", "button_icon" )->attr( "data-icon",
                        "cross" )->attr( "data-icon-placing", "right" ) );

        // Confirm button
        $buttonsGui->addContent(
                Xhtml::a( "Confirm" )->title( "Confirm" )->href(
                        sprintf( "javascript: Core.postToUrl('%s');",
                                Resource::url()->cms()->buildings()->getDeleteBuildingPage(
                                        $this->getBuildings()->getIds(), $this->getMode() ) ) )->addClass(
                        Resource::css()->gui()->getComponent() )->attr( "data-type", "button_icon" )->attr( "data-icon",
                        "check" )->attr( "data-icon-placing", "right" ) );

        $root->addContent( $buttonsGui );

    }

    // /FUNCTIONS


}

?>