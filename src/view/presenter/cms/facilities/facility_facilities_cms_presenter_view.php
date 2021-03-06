<?php

class FacilityFacilitiesCmsPresenterView extends PresenterView
{

    // VARIABLES


    public static $NAME_FACILITY_CHECK = "facility_check";

    private static $ID_FACILITIES_CHECK = "facilities_check";

    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var BuildingListModel
     */
    private $buildings;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->setFacility( FacilityFactoryModel::createFacility( "" ) );
        $this->setBuildings( new BuildingListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


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
     * @return BuildingListModel
     */
    public function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * @param BuildingListModel $buildings
     */
    public function setBuildings( BuildingListModel $buildings )
    {
        $this->buildings = $buildings;
    }

    // ... /GETTERS/SETTERS

    // ... CREATE


    /**
     * @return AbstractXhtml
     */
    private function createActivity()
    {

        // Get activity time
        $activityTime = $this->getFacility()->getUpdated() ? $this->getFacility()->getUpdated() : $this->getFacility()->getRegistered();

        $wrapper = Xhtml::div();
        $wrapper->addContent(
                Xhtml::div(
                        ucfirst(
                                $this->getFacility()->getUpdated() ? $this->getLocale()->getUpdated() : $this->getLocale()->getRegistered() ) ) );
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

        // Create body
        $body = Xhtml::tbody()->class_(
                Resource::css()->cms()->facility()->getFacilitiesTableBody() );

        // Draw Facility to body
        $this->drawFacility( $body );

        // Draw Facility Buildings to body
        $this->drawFacilityBuildings( $body );

        // Add body to root
        $root->addContent( $body );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawFacility( AbstractXhtml $root )
    {

        // Create row
        $row = Xhtml::tr()->class_( Resource::css()->cms()->facility()->getFacility() )->id(
                sprintf( "facility_%s", $this->getFacility()->getId() ) );

        // Facility check
        $row->addContent(
                Xhtml::td(
                        Xhtml::input( $this->getFacility()->getId(), self::$NAME_FACILITY_CHECK )->type(
                                InputXhtml::$TYPE_CHECKBOX ) )->class_(
                        Resource::css()->cms()->facility()->getCheck() ) );

        // Facility map
        $map = Xhtml::img(
                Resource::url()->cms()->facility()->getFacilityImage( $this->getFacility()->getId(),
                        null, null, $this->getView()->getController()->getMode() ), "Map" )->class_(
                $this->getBuildings()->isEmpty() ? Resource::css()->cms()->getInactive() : "" );
        $row->addContent( Xhtml::td( $map )->class_( Resource::css()->cms()->facility()->getMap() ) );

        // Facility name
        $row->addContent(
                Xhtml::td(
                        Xhtml::a( $this->getFacility()->getName() )->href(
                                Resource::url()->cms()->facility()->getViewFacilityPage(
                                        $this->getFacility()->getId(), $this->getView()->getController()->getMode() ) ) )->class_(
                        Resource::css()->cms()->facility()->getName() ) );

        // Facility buildings
        $row->addContent(
                Xhtml::td(
                        $this->getFacility()->getBuildings() > 0 ? $this->getFacility()->getBuildings() : Xhtml::span(
                                ucfirst( $this->getLocale()->getNone() ) )->class_( Resource::css()->getItalic(),
                                Resource::css()->getGray() ) )->class_(
                        Resource::css()->cms()->facility()->getBuildings() ) );

        // Facility activity
        $row->addContent(
                Xhtml::td( $this->createActivity() )->class_(
                        Resource::css()->cms()->facility()->getActivity() ) );

        // Add row to root
        $root->addContent( $row );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawFacilityBuildings( AbstractXhtml $root )
    {

        // Must have Buildings
        if ( $this->getBuildings()->isEmpty() )
        {
            return;
        }

        // Create row
        $rowId = sprintf( "facility_buildings_%s", $this->getFacility()->getId() );
        $row = Xhtml::tr()->class_( Resource::css()->cms()->facility()->getFacilityBuildings() )->id(
                $rowId );

        // Create cell
        $cell = Xhtml::td()->colspan( 5 );

        // Create wrapper
        $wrapper = Xhtml::div()->class_(
                Resource::css()->cms()->facility()->getFacilityBuildingsWrapper() );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable(),
                Resource::css()->cms()->facility()->getFacilityBuildingsTable() )->attr(
                "data-width-parent",
                sprintf( "#%s .%s", $rowId,
                        Resource::css()->cms()->facility()->getFacilityBuildingsWrapper() ) );

        // Foreach Buildings
        for ( $this->getBuildings()->rewind(); $this->getBuildings()->valid(); $this->getBuildings()->next() )
        {
            $building = $this->getBuildings()->current();

            // Create div
            $div = Xhtml::div();

            // Draw Facility Building to cell
            $this->drawFacilityBuilding( $div, $building );

            // Add div to table
            $table->addContent( $div );

        }

        // Add spacer to table
        $table->addContent( Xhtml::div( Xhtml::$NBSP )->class_( Resource::css()->getTableCellFill() ) );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to cell
        $cell->addContent( $wrapper );

        // Add cell to row
        $row->addContent( $cell );

        // Add row to root
        $root->addContent( $row );

    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawFacilityBuilding( AbstractXhtml $root, BuildingModel $building )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_(
                Resource::css()->cms()->facility()->getFacilityBuildingsBuildingWrapper() );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable(),
                Resource::css()->cms()->facility()->getFacilityBuildingsBuildingTable() )->style(
                sprintf( "background-image: url(%s)",
                        //Resource::url()->cms()->building()->getBuildingOverviewImage( $building->getId(), 150, 75, $this->getMode() ) ) );
                        Resource::url()->cms()->buildings()->getBuildingMapImage( $building->getId(), 150, 75, $this->getMode() ) ) );

        // Create cell
        $cell = Xhtml::div()->title( $building->getName() );

        // Create div
        $div = Xhtml::div(
                Xhtml::a( $building->getName() )->href(
                        Resource::url()->cms()->buildings()->getViewBuildingPage( $building->getId(),
                                $this->getView()->getController()->getMode() ) ) )->class_(
                Resource::css()->cms()->facility()->getFacilityBuildingsBuildingContent() )->title(
                $building->getName() );

        // Add div to cell
        $cell->addContent( $div );

        // Add cell to table
        $table->addContent( $cell );

        // Add taable to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    public static function drawHeader( AbstractXhtml $root )
    {

        // Create row
        $row = Xhtml::tr();

        // Facility check
        $row->addContent(
                Xhtml::td( Xhtml::input()->type( InputXhtml::$TYPE_CHECKBOX )->id( self::$ID_FACILITIES_CHECK ) )->class_(
                        Resource::css()->cms()->facility()->getCheck() ) );

        // Facility map
        $row->addContent(
                Xhtml::td( "Map" )->class_( Resource::css()->cms()->facility()->getMap() ) );

        // Facility name
        $row->addContent(
                Xhtml::td( "Name" )->class_( Resource::css()->cms()->facility()->getName() ) );

        // Facility buildings
        $row->addContent(
                Xhtml::td( "Buildings" )->class_( Resource::css()->cms()->facility()->getBuildings() ) );

        // Facility activity
        $row->addContent(
                Xhtml::td( "Activity" )->class_( Resource::css()->cms()->facility()->getActivity() ) );

        // Add row to root
        $root->addContent( $row );

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>