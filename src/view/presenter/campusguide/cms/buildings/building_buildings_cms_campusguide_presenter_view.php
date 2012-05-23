<?php

class BuildingBuildingsCmsCampusguidePresenterView extends PresenterView
{

    // VARIABLES


    public static $NAME_BUILDING_CHECK = "building_check";

    private static $ID_BUILDINGS_CHECK = "buildings_check";

    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var FacilityModel
     */
    private $facility;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->setBuilding( BuildingFactoryModel::createBuilding( "", 0, array () ) );
        $this->setFacility( FacilityFactoryModel::createFacility( "" ) );
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


    // ... GET


    /**
     * @return DefaultLocale
     */
    private function getLocale()
    {
        return $this->getView()->getController()->getLocale();
    }

    // ... /GET


    // ... CREATE


    /**
     * @return AbstractXhtml
     */
    private function createActivity()
    {

        // Get activity time
        $activityTime = $this->getBuilding()->getUpdated() ? $this->getBuilding()->getUpdated() : $this->getBuilding()->getRegistered();

        $wrapper = Xhtml::div();
        $wrapper->addContent(
                Xhtml::div(
                        ucfirst(
                                $this->getBuilding()->getUpdated() ? $this->getLocale()->getUpdated() : $this->getLocale()->getRegistered() ) ) );
        $wrapper->addContent( Xhtml::div( $this->getLocale()->timeSince( $activityTime ) ) );

        return $wrapper;

    }

    // ... /CREATE


    // ... DRAW


    /**
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Draw Building to body
        $this->drawBuilding( $root );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawBuilding( AbstractXhtml $root )
    {

        // Create row
        $row = Xhtml::tr()->class_( Resource::css()->campusguide()->cms()->building()->getBuilding() )->id(
                sprintf( "building_%s", $this->getBuilding()->getId() ) );

        // Building check
        $row->addContent(
                Xhtml::td(
                        Xhtml::input( $this->getBuilding()->getId(), self::$NAME_BUILDING_CHECK )->type(
                                InputXhtml::$TYPE_CHECKBOX ) )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingCheck() ) );

        // Building Facility
        $cell = Xhtml::td()->class_( Resource::css()->campusguide()->cms()->building()->getBuildingFacility() );
        $this->drawBuildingFacility( $cell );
        $row->addContent( $cell );

        // Building overview
        $cell = Xhtml::td()->class_( Resource::css()->campusguide()->cms()->building()->getBuildingOverview() );
        $this->drawBuildingOverview( $cell );
        $row->addContent( $cell );

        // Building building
        $buildingName = Xhtml::div(
                Xhtml::a( $this->getBuilding()->getName() )->href(
                        Resource::url()->campusguide()->cms()->building()->getViewBuildingPage(
                                $this->getBuilding()->getId(), $this->getView()->getController()->getMode() ) ) )->addClass(
                Resource::css()->campusguide()->cms()->building()->getBuildingBuildingName() );
        $buildingAddress = Xhtml::div( implode( ", ", Core::empty_( $this->getBuilding()->getAddress(), array () ) ) )->addClass(
                Resource::css()->campusguide()->cms()->building()->getBuildingBuildingAddress() );

        $row->addContent(
                Xhtml::td( $buildingName )->addContent( $buildingAddress )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingBuilding() ) );

        // Bulding floors
        $row->addContent(
                Xhtml::td(
                        $this->getBuilding()->getFloors() > 0 ? $this->getBuilding()->getFloors() : Xhtml::span(
                                ucfirst( $this->getLocale()->getNone() ) )->class_( Resource::css()->getItalic(),
                                Resource::css()->getGray() ) )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingFloors() ) );

        // Facility activity
        $row->addContent(
                Xhtml::td( $this->createActivity() )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingActivity() ) );

        // Add row to root
        $root->addContent( $row );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawBuildingFacility( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() )->style(
                sprintf( "background-image: url('%s');",
                        Resource::url()->campusguide()->cms()->facility()->getImageController(
                                $this->getFacility()->getId(), 150, 75, $this->getView()->getController()->getMode() ) ) );

        // Create Facility link
        $facilityLink = Xhtml::a( $this->getFacility()->getName() )->href(
                Resource::url()->campusguide()->cms()->facility()->getViewFacilityPage( $this->getFacility()->getId(),
                        $this->getView()->getController()->getMode() ) );

        $table->addContent( Xhtml::div( Xhtml::div( $facilityLink ) )->title( $this->getFacility()->getName() ) );

        $root->addContent( $table );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawBuildingOverview( AbstractXhtml $root )
    {

        // Create img
        $img = Xhtml::img(
                Resource::url()->campusguide()->cms()->building()->getImageController( $this->getBuilding()->getId(),
                        150, 75, $this->getView()->getController()->getMode() ) );

        $root->addContent( $img );

    }

    /**
     * @param AbstractXhtml $root
     */
    public static function drawHeader( AbstractXhtml $root )
    {

        // Create row
        $row = Xhtml::tr();

        // Building check
        $row->addContent(
                Xhtml::td( Xhtml::input()->type( InputXhtml::$TYPE_CHECKBOX )->id( self::$ID_BUILDINGS_CHECK ) )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingCheck() ) );

        // Building Facility
        $row->addContent(
                Xhtml::td( "Facility" )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingFacility() ) );

        // Building overview
        $row->addContent(
                Xhtml::td( "Overview" )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingOverview() ) );

        // Building building
        $row->addContent(
                Xhtml::td( "Building" )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingBuilding() ) );

        // Building floors
        $row->addContent(
                Xhtml::td( "Floors" )->class_( Resource::css()->campusguide()->cms()->building()->getBuildingFloors() ) );

        // Building activity
        $row->addContent(
                Xhtml::td( "Activity" )->class_(
                        Resource::css()->campusguide()->cms()->building()->getBuildingActivity() ) );

        // Add row to root
        $root->addContent( $row );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>