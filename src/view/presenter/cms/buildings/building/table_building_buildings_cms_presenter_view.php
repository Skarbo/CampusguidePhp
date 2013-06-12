<?php

class TableBuildingBuildingsCmsPresenterView extends AbstractPresenterView
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
    /**
     * @var FloorBuildingListModel
     */
    private $floors;

    /**
     * @var SelectsliderCmsPresenterView
     */
    private $buildingFloorsSliderPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->setBuilding( BuildingFactoryModel::createBuilding( "", 0 ) );
        $this->setFacility( FacilityFactoryModel::createFacility( "" ) );
        $this->setFloors( new FloorBuildingListModel() );

        $this->buildingFloorsSliderPresenter = new SelectsliderCmsPresenterView( $this->getView(),
                "select_building_floor", "%s",
                Resource::url()->cms()->buildings()->getBuildingOverviewImage( "%s", 200, 100, $this->getMode() ) );
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

    /**
     * @return FloorBuildingListModel
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * @param FloorBuildingListModel $floors
     */
    public function setFloors( FloorBuildingListModel $floors )
    {
        $this->floors = $floors;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
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
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Draw Building to root
        $this->drawBuilding( $root );

    }

    // ... ... BUILDING


    /**
     * @param AbstractXhtml $root
     */
    private function drawBuilding( AbstractXhtml $root )
    {

        // Create row
        $row = Xhtml::tr()->class_( Resource::css()->cms()->buildings()->overview()->buildingRow )->id(
                sprintf( "building_%s", $this->getBuilding()->getId() ) );

        // Building check
        $row->addContent(
                Xhtml::td(
                        Xhtml::input( $this->getBuilding()->getId(), self::$NAME_BUILDING_CHECK )->type(
                                InputXhtml::$TYPE_CHECKBOX ) )->class_(
                        Resource::css()->cms()->buildings()->overview()->buildingRowCheck ) );

        // Building Facility
        $cell = Xhtml::td()->class_( Resource::css()->cms()->buildings()->overview()->buildingRowFacility );
        $this->drawBuildingFacility( $cell );
        $row->addContent( $cell );

        // Building overview
        $cell = Xhtml::td()->class_( Resource::css()->cms()->buildings()->overview()->buildingRowOverview );
        $this->drawBuildingOverview( $cell );
        $row->addContent( $cell );

        // Building building
        $buildingName = Xhtml::div(
                Xhtml::a( $this->getBuilding()->getName() )->href(
                        Resource::url()->cms()->buildings()->getViewBuildingPage( $this->getBuilding()->getId(),
                                $this->getView()->getController()->getMode() ) ) )->addClass(
                Resource::css()->cms()->buildings()->overview()->buildingRowBuildingName );
        $buildingAddress = Xhtml::div( implode( ", ", Core::empty_( $this->getBuilding()->getAddress(), array () ) ) )->addClass(
                Resource::css()->cms()->buildings()->overview()->buildingRowBuildingAddress );

        $row->addContent(
                Xhtml::td( $buildingName )->addContent( $buildingAddress )->class_(
                        Resource::css()->cms()->buildings()->overview()->buildingRowBuilding ) );

        // Bulding floors
        $row->addContent(
                Xhtml::td(
                        $this->getBuilding()->getFloors() > 0 ? $this->getBuilding()->getFloors() : Xhtml::span(
                                ucfirst( $this->getLocale()->getNone() ) )->class_( Resource::css()->getItalic(),
                                Resource::css()->getGray() ) )->class_(
                        Resource::css()->cms()->buildings()->overview()->buildingRowFloors ) );

        // Facility activity
        $row->addContent(
                Xhtml::td( $this->createActivity() )->class_(
                        Resource::css()->cms()->buildings()->overview()->buildingRowActivity ) );

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
                        Resource::url()->cms()->facility()->getFacilityImage( $this->getFacility()->getId(), 150, 75,
                                $this->getMode( true ) ) ) );

        // Create Facility link
        $facilityLink = Xhtml::a( $this->getFacility()->getName() )->href(
                Resource::url()->cms()->facility()->getViewFacilityPage( $this->getFacility()->getId(),
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
                Resource::url()->cms()->buildings()->getBuildingOverviewImage( $this->getBuilding()->getId(), 150, 75,
                        $this->getMode() ) )->style(
                sprintf( "background-image: url('%s');",
                        Resource::url()->cms()->buildings()->getBuildingMapImage( $this->getBuilding()->getId(), 150,
                                75, $this->getMode() ) ) );

        $root->addContent( $img );

    }

    // ... ... /BUILDING


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
                        Resource::css()->cms()->buildings()->overview()->buildingRowCheck ) );

        // Building Facility
        $row->addContent(
                Xhtml::td( "Facility" )->class_( Resource::css()->cms()->buildings()->overview()->buildingRowFacility ) );

        // Building overview
        $row->addContent(
                Xhtml::td( "Overview" )->class_( Resource::css()->cms()->buildings()->overview()->buildingRowOverview ) );

        // Building building
        $row->addContent(
                Xhtml::td( "Building" )->class_( Resource::css()->cms()->buildings()->overview()->buildingRowBuilding ) );

        // Building floors
        $row->addContent(
                Xhtml::td( "Floors" )->class_( Resource::css()->cms()->buildings()->overview()->buildingRowFloors ) );

        // Building activity
        $row->addContent(
                Xhtml::td( "Activity" )->class_( Resource::css()->cms()->buildings()->overview()->buildingRowActivity ) );

        // Add row to root
        $root->addContent( $row );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>