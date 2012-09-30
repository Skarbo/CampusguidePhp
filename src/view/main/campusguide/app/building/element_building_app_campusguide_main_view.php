<?php

class ElementBuildingAppCampusguideMainView extends AppCampusguideMainView implements ElementBuildingAppCampusguideInterfaceView
{

    // VARIABLES


    public static $ID_ELEMENT_PAGE_WRAPPER = "building_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppCampusguideMainView::getController()
     * @return ElementBuildingAppCampusguideMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see ElementBuildingAppCampusguideInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getController()->getBuilding();
    }

    /**
     * @see ElementBuildingAppCampusguideInterfaceView::getFacility()
     */
    public function getFacility()
    {
        return $this->getController()->getFacility();
    }

    /**
     * @see ElementBuildingAppCampusguideInterfaceView::getFloor()
     */
    public function getFloor()
    {
        return $this->getController()->getFloor();
    }

    /**
     * @see ElementBuildingAppCampusguideInterfaceView::getElement()
     */
    public function getElement()
    {
        return $this->getController()->getElement();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AppCampusguideMainView::drawPage()
     */
    protected function drawPage( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_ELEMENT_PAGE_WRAPPER )->attr( "data-fitparent",
                sprintf( "#%s", self::$ID_PAGE_WRAPPER ) );

        $wrapper->addContent(Xhtml::div( $this->getBuilding()->getName() )->class_(Resource::css()->getRight()));

        $wrapper->addContent(Xhtml::hr());

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @see AppCampusguideMainView::drawMenu()
     */
    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {
        $this->getActionbarPresenter()->setIcon(
                Xhtml::img( Resource::image()->icon()->getRoomAuditoriumSvg( "white" ) )->style( "height: 1em;" ) );
        $this->getActionbarPresenter()->setBackReferer(
                Resource::url()->campusguide()->app()->building()->getBuilding( $this->getBuilding()->getId(),
                        $this->getMode() ) );

        $this->getActionbarPresenter()->addViewControl(
                Xhtml::div( Xhtml::div( $this->getElement()->getName() ) )->addContent( Xhtml::div( "Room type" ) )->class_(
                        "double" ) );

        $this->getActionbarPresenter()->draw( $rootTop );
        $this->getActionbarPresenter()->drawBottom( $rootBottom );
    }

    // ... /DRAW


    // /FUNCTIONS


}

?>