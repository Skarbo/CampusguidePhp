<?php

class BuildingBuildingsCmsPresenterView extends PresenterView
{

    // VARIABLES


    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var BuildingModel
     */
    private $building;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractPresenterView::__construct()
     */
    public function __construct( AbstractMainView $view )
    {
        parent::__construct( $view );

        $this->facility = FacilityFactoryModel::createFacility( "" );
        $this->building = BuildingFactoryModel::createBuilding( "", 0 );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return BuildingModel
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param BuildingModel $building
     */
    public function setBuilding( BuildingModel $building )
    {
        $this->building = $building;
    }

    /**
     * @return FacilityModel
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * @param FacilityModel $facility
     */
    public function setFacility( FacilityModel $facility )
    {
        $this->facility = $facility;
    }

    // ... /GETTERS/SETTERS


    // ... DRAW


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create Facility Overlaybackground Widget
        $facilityOverlaybackgroundWidget = OverlaybackgroundCmsWidgetView::init( $this )->backgroundImage(
                Resource::url()->cms()->facility()->getFacilityImage( $this->getFacility()->getId(), 100, 200,
                        $this->getMode() ), 100, 200 )->link(
                Resource::url()->cms()->facility()->getViewFacilityPage( $this->getFacility()->getId(),
                        $this->getMode() ) )->title( $this->getFacility()->getName() );

        // Create Building image
        $buildingImage = Xhtml::img(
                Resource::url()->cms()->buildings()->getBuildingMapImage( $this->getBuilding()->getId(), 200, 100,
                        $this->getMode() ) );

        // Create Building div
        $buildingDiv = Xhtml::div();
        $buildingDiv->addContent(
                Xhtml::a( Xhtml::h( 3, $this->getBuilding()->getName() ),
                        Resource::url()->cms()->buildings()->getViewBuildingPage( $this->getBuilding()->getId(),
                                $this->getMode() ) ) );
        $buildingDiv->addContent( Xhtml::div( implode( ", ", $this->getBuilding()->getAddress() ) ) );
        $buildingDiv->addContent(
                Xhtml::div( $this->getLocale()->building()->getFloors( $this->getBuilding()->getFloors() ) ) );
        $buildingDiv->addContent(
                Xhtml::div(
                        $this->getLocale()->getActivity( $this->getBuilding()->getRegistered(),
                                $this->getBuilding()->getUpdated() ) ) );

        // Create wrapper
        $wrapper = Xhtml::div()->class_( "building_buildings_presenter_wrapper" );

        $facilityOverlaybackgroundWidget->draw( $wrapper );
        $wrapper->addContent( $buildingImage );
        $wrapper->addContent( $buildingDiv );

        $root->addContent( $wrapper );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>