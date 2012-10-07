<?php

class SearchRestController extends RestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "search";

    const URI_SEARCH = 1;
    const URI_TYPE = 2;
    const URI_ID = 3;

    const TYPE_BUILDING = "building";
    private static $TYPES = array ( self::TYPE_BUILDING );

    const QUERY_SIMPLE = "simple";

    /**
     * @var FacilityListModel
     */
    private $facilites;
    /**
     * @var BuildingListModel
     */
    private $buildings;
    /**
     * @var ElementBuildingListModel
     */
    private $elements;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setFacilities( new FacilityListModel() );
        $this->setBuildings( new BuildingListModel() );
        $this->setElements( new ElementBuildingListModel() );
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

    /**
     * @return ElementBuildingListModel
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param ElementBuildingListModel $elements
     */
    private function setElements( ElementBuildingListModel $elements )
    {
        $this->elements = $elements;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    public static function getSearchUri()
    {
        return self::getURI( self::URI_SEARCH );
    }

    private static function getTypeUri()
    {
        return self::getURI( self::URI_TYPE );
    }

    private static function getIdUri()
    {
        return intval( self::getURI( self::URI_ID, 0 ) );
    }

    public static function getSimpleQuery()
    {
        return Core::arrayAt( self::getQuery(), self::QUERY_SIMPLE );
    }

    /**
     * @see RestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified(), $this->getFacilities()->getLastModified(),
                $this->getBuildings()->getLastModified() );
    }

    private function getSearchString()
    {
        return sprintf( "%%%s%%", preg_replace( "/[^\\w]/", "%", self::getSearchUri() ) );
    }

    // ... /GET


    // ... IS


    private static function isCommandSearchAll()
    {
        return self::getSearchUri() && !self::getTypeUri();
    }

    private static function isCommandSearchType()
    {
        return self::getSearchUri() && self::getTypeUri() && in_array( self::getTypeUri(), self::$TYPES ) && self::getIdUri();
    }

    public function isSimple()
    {
        return ( boolean ) self::getSimpleQuery();
    }

    // ... /IS


    // ... DO


    private function doSearchAllCommand()
    {

        // Search string
        $searchString = $this->getSearchString();

        // SEARCH


        // Facilities
        $this->setFacilities( $this->getDaoContainer()->getFacilityDao()->search( $searchString ) );

        // Buildings
        $this->setBuildings( $this->getDaoContainer()->getBuildingDao()->search( $searchString ) );

        // Elements
        $this->setElements( $this->getDaoContainer()->getElementBuildingDao()->search( $searchString ) );

        // /SEARCH


    }

    private function doSearchTypeCommand()
    {
        switch ( self::getTypeUri() )
        {

            case self::TYPE_BUILDING :
                $this->doBuildingSearch( $this->getSearchString(), self::getIdUri() );
                break;

        }
    }

    private function doBuildingSearch( $search, $buildingId = null )
    {
        $this->setElements( $this->getDaoContainer()->getElementBuildingDao()->search( $search, $buildingId ) );
    }

    // ... /DO


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        if ( self::isCommandSearchAll() )
        {
            $this->doSearchAllCommand();
        }
        else if ( self::isCommandSearchType() )
        {
            $this->doSearchTypeCommand();
        }
        else
        {
            if ( !self::getSearchString() )
                throw new BadrequestException( "Missing search string" );
            if ( !in_array( self::getTypeUri(), self::$TYPES ) )
                throw new BadrequestException( sprintf( "Uknown type search \"%s\"", self::getTypeUri() ) );
            if ( self::getTypeUri() && !self::getIdUri() )
                throw new BadrequestException( "Missing search type id" );
            throw new BadrequestException();
        }
    }

    // /FUNCTIONS


}

?>