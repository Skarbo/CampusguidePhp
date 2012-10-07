<?php

class ElementBuildingAppMainView extends AppMainView implements ElementBuildingAppInterfaceView
{

    // VARIABLES


    public static $ID_ELEMENT_PAGE_WRAPPER = "building_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppMainView::getController()
     * @return ElementBuildingAppMainController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see ElementBuildingAppInterfaceView::getBuilding()
     */
    public function getBuilding()
    {
        return $this->getController()->getBuilding();
    }

    /**
     * @see ElementBuildingAppInterfaceView::getFacility()
     */
    public function getFacility()
    {
        return $this->getController()->getFacility();
    }

    /**
     * @see ElementBuildingAppInterfaceView::getFloor()
     */
    public function getFloor()
    {
        return $this->getController()->getFloor();
    }

    /**
     * @see ElementBuildingAppInterfaceView::getElement()
     */
    public function getElement()
    {
        return $this->getController()->getElement();
    }

    // ... /GET


    // ... DRAW


    /**
     * @see AppMainView::drawPage()
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
     * @see AppMainView::drawMenu()
     */
    protected function drawMenu( AbstractXhtml $rootTop, AbstractXhtml $rootBottom )
    {
        $this->getActionbarPresenter()->setIcon(
                Xhtml::img( Resource::image()->icon()->getRoomAuditoriumSvg( "white" ) )->style( "height: 1em;" ) );
        $this->getActionbarPresenter()->setBackReferer(
                Resource::url()->app()->building()->getBuilding( $this->getBuilding()->getId(),
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