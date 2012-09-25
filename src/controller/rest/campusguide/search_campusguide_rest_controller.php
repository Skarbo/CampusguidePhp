<?php

class SearchCampusguideRestController extends CampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "search";

    const URI_SEARCH = 1;

    /**
     * @var FacilityListModel
     */
    private $facilites;
    /**
     * @var BuildingListModel
     */
    private $buildings;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setFacilities( new FacilityListModel() );
        $this->setBuildings( new BuildingListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return FacilityListModel
     */
    public function getFacilities()
    {
        return $this->facilites;
    }

    /**
     * @param FacilityListModel $facilites
     */
    public function setFacilities( FacilityListModel $facilites )
    {
        $this->facilites = $facilites;
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


    // ... GET


    public static function getSearchString()
    {
        return self::getURI( self::URI_SEARCH );
    }


    /**
     * @see CampusguideRestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified(), $this->getFacilities()->getLastModified(), $this->getBuildings()->getLastModified() );
    }

    // ... /GET


    // ... DO


    private function doSearchCommand()
    {

        // Search string
        $searchString = sprintf( "%%%s%%", preg_replace( "/[^\\w]/", "%",
                self::getSearchString() ) );

        // SEARCH


        // Facilities
        $this->setFacilities( $this->getCampusguideHandler()->getFacilityDao()->search( $searchString ) );

        // Buildings
        $this->setBuildings( $this->getCampusguideHandler()->getBuildingDao()->search( $searchString ) );

        // /SEARCH


    }

    // ... /DO


    /**
     * @see Controller::request()
     */
    public function request()
    {

        if ( self::getSearchString() )
        {
            $this->doSearchCommand();
        }
        else
        {
            throw new BadrequestException( "Missing search string" );
        }

    }

    // /FUNCTIONS



}

?>