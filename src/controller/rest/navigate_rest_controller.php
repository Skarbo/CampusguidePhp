<?php

class NavigateRestController extends RestController
{

    // VARIABLES


    const URI_ELEMENT = 1;

    public static $CONTROLLER_NAME = "navigate";

    public static $POST_NAVIGATE = "navigate";
    public static $POST_NAVIGATE_POSITION = "position"; // Array( x => x, y => y, floor => floorId )
    public static $POST_NAVIGATE_INELEMENT = "inelement"; // Position is inside an element, element id


    /**
     * @var NavigateHandler
     */
    private $navigateHandler = null;
    private $navigatePath = null;
    private $position = array ();
    private $floor = null;
    private $element = null;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see RestController::__construct()
     */
    public function __construct( Api $api, View $view )
    {
        parent::__construct($api, $view);
        $this->navigateHandler = new NavigateHandler();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    private function getElementIdRequest()
    {
        return intval( self::getURI( self::URI_ELEMENT ) );
    }

    /**
     * @return Array Array( Node id, ... )|Null if no path found
     */
    public function getNavigatePath()
    {
        return $this->navigatePath;
    }

    /**
     * @return array
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return FloorBuildingModel
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @return ElementBuildingModel
     */
    public function getElement()
    {
        return $this->element;
    }

    // ... IS


    private function isNavigate()
    {
        return $this->getElementIdRequest() && self::isPost();
    }

    // ... /IS


    // ... DO


    private function doNavigateRequest()
    {

        $elementId = $this->getElementIdRequest();
        $this->element = $this->getDaoContainer()->getElementBuildingDao()->get( $elementId );

        if ( !$this->element )
        {
            throw new BadrequestException( sprintf( "Element \"%s\" does not exist", $elementId ) );
        }

        $navigatePost = Core::arrayAt( self::getPost(), self::$POST_NAVIGATE, array () );
        DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "NavigatePost", $navigatePost ) );

        $positionPost = Core::arrayAt( $navigatePost, self::$POST_NAVIGATE_POSITION );

        if ( empty( $positionPost ) )
            throw new BadrequestException( "Position is not given" );

        $x = Core::arrayAt( $positionPost, "x" );
        $y = Core::arrayAt( $positionPost, "y" );
        $floorId = intval( Core::arrayAt( $positionPost, "floorId" ) );
        if ( $x === null || $y === null )
            throw new BadrequestException( "X or Y position coordinate is null" );

        $this->position = array ( "x" => $x, "y" => $y );
DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "NavigateRestController.doNavitaerRequest", self::getPost(),$positionPost, $x, $y ), $this->position );

        $this->floor = $this->getDaoContainer()->getFloorBuildingDao()->get( $floorId );
        if ( !$this->floor )
            throw new BadrequestException( sprintf( "Floor id \"%s\" given with position does not exist", $floorId ) );

        $elementFloor = $this->getDaoContainer()->getFloorBuildingDao()->get( $this->element->getFloorId() );
        if ( !$elementFloor )
            throw new BadrequestException( sprintf( "Element \"%s\" is not in the same building as Floor \"%s\"" ) );

        $elementNavigationNode = $this->getDaoContainer()->getNodeNavigationBuildingDao()->getElement(
                $this->element->getId() );
        if ( !$elementNavigationNode )
            throw new BadrequestException(
                    sprintf( "Element \"%s\" is not connected to a navigation node", $this->element->getId() ) );

        $buildingNavigationNodes = $this->getDaoContainer()->getNodeNavigationBuildingDao()->getBuilding(
                $this->floor->getForeignId() );

        // Handle Navigation
        $this->navigatePath = $this->navigateHandler->handle( $this->element, $this->position, $this->floor,
                $buildingNavigationNodes );

    }

    // ... /DO


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        if ( $this->isNavigate() )
        {
            $this->doNavigateRequest();
        }
        else
        {
            throw new BadrequestException( "Must be POST request and element id must be given" );
        }
    }

    // /FUNCTIONS


}

?>