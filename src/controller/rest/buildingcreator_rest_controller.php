<?php

class BuildingcreatorRestController extends RestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingcreator";
    private static $TYPES_SPLITTER = "_";
    private static $FLOORS_SPLITTER = "_";

    const URI_BUILDING = 1;
    const URI_FLOORS = 2;
    const URI_TYPES = 3;

    const TYPE_ELEMENTS = "elements";
    const TYPE_NAVIGATIONS = "navigations";

    /**
     * @var BuildingContainer
     */
    private $buildingContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->buildingContainer = new BuildingContainer();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return BuildingContainer
     */
    public function getBuildingContainer()
    {
        return $this->buildingContainer;
    }

    // ... /GET


    // ... GET


    public function getBuildingIdUri()
    {
        return intval( self::getURI( self::URI_BUILDING ) );
    }

    public function getFloorIdsUri()
    {
        return array_filter( explode( self::$FLOORS_SPLITTER, self::getURI( self::URI_FLOORS ) ) );
    }

    public function getTypesUri()
    {
        return array_filter( explode( self::$TYPES_SPLITTER, self::getURI( self::URI_TYPES ) ) );
    }

    /**
     * @see RestController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified(), $this->getBuildingContainer()->getLastModified() );
    }

    // ... /GET


    // ... DO


    private function doBuildingCommand()
    {
        $buildingId = $this->getBuildingIdUri();
        if ( !$buildingId )
            throw new BadrequestException( "Building id is not given" );

        $this->getBuildingContainer()->setBuilding( $this->getDaoContainer()->getBuildingDao()->get( $buildingId ) );
        if ( !$this->getBuildingContainer()->getBuilding() )
            throw new BadrequestException( sprintf( "Building \"%d\" does not exist", $buildingId ) );

        $floorIds = $this->getFloorIdsUri();
        $this->getBuildingContainer()->setFloors(
                $floorIds ? $this->getDaoContainer()->getFloorBuildingDao()->getList( $floorIds ) : $this->getDaoContainer()->getFloorBuildingDao()->getMainFloors(
                        array ( $this->getBuildingContainer()->getBuilding()->getId() ) ) );

        foreach ( $this->getTypesUri() as $type )
        {
            switch ( $type )
            {
                case self::TYPE_ELEMENTS :
                    $this->getBuildingContainer()->setElements(
                            $this->getDaoContainer()->getElementBuildingDao()->getForeign(
                                    $this->getBuildingContainer()->getFloors()->getIds() ) );
                    break;
                case self::TYPE_NAVIGATIONS :
                    $this->getBuildingContainer()->setNavigations(
                            $this->getDaoContainer()->getNodeNavigationBuildingDao()->getForeign(
                                    $this->getBuildingContainer()->getFloors()->getIds() ) );
                    break;
            }
        }
    }

    // ... /DO


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        $this->doBuildingCommand();
    }

    // /FUNCTIONS


}

?>