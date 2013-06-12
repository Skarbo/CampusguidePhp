<?php

class NavigationBuildingRestController extends StandardRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingnavigation";

    public static $POST_NAVIGATION_NODES = "anchors";
    public static $POST_NAVIGATION_EDGES = "relationship";

    const COMMAND_NAVIGATION = "navigation";
    const COMMAND_BUILDING = "building";

    /**
     * @var NavigationBuildingHandler
     */
    private $navigationHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->navigationHandler = new NavigationBuildingHandler( $this->getDaoContainer() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    protected function getForeignStandardDao()
    {
        return $this->getDaoContainer()->getFloorBuildingDao();
    }

    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getNodeNavigationBuildingDao();
    }

    protected function getModelPost()
    {

        $nodeObject = self::getPostObject();

        $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $this->getForeignModel()->getId(),
                Core::arrayAt( $nodeObject, NodeNavigationBuildingModel::COORDINATE ),
                Core::arrayAt( $nodeObject, NodeNavigationBuildingModel::ELEMENTID ),
                Core::arrayAt( $nodeObject, NodeNavigationBuildingModel::EDGES ) );

        return $node;

    }

    // ... /GET


    // ... IS


    private function isRequestNavigation()
    {
        return self::getURI( self::URI_COMMAND ) == self::COMMAND_NAVIGATION && self::getId() && self::isPost();
    }

    private function isRequestNavigate()
    {
        return self::getURI( self::URI_COMMAND ) == self::COMMAND_NAVIGATE && self::getId() && self::isPost();
    }

    private function isRequestBuilding()
    {
        return self::getURI( self::URI_COMMAND ) == self::COMMAND_BUILDING && self::getId();
    }

    // ... /IS


    private function doRequestNavigation()
    {

        // Building
        $floorId = self::getId();
        $floor = $this->getDaoContainer()->getFloorBuildingDao()->get( $floorId );

        if ( !$floor )
        {
            throw new BadrequestException( sprintf( "Floor \"%s\" does not exist", $floorId ) );
        }

        // NAVIGATION


        // Handle each Navigation floor
        $this->navigationHandler->handle( $floor->getId(),
                Core::arrayAt( self::getPostObject(), self::$POST_NAVIGATION_NODES, array () ),
                Core::arrayAt( self::getPostObject(), self::$POST_NAVIGATION_EDGES, array () ) );

        // /NAVIGATION


        $this->setModelList( $this->getDaoContainer()->getNodeNavigationBuildingDao()->getForeign( $floor->getId() ) );

    }

    private function doRequestBuilding()
    {

        // Floors
        $floors = $this->getDaoContainer()->getFloorBuildingDao()->getForeign( array ( self::getId() ) );

        // Set Building Nodes to Model List
        $this->setModelList(
                $this->getDaoContainer()->getNodeNavigationBuildingDao()->getForeign( $floors->getIds() ) );

    }

    public function request()
    {
        if ( $this->isRequestNavigation() )
        {
            $this->doRequestNavigation();
        }
        else if ( $this->isRequestBuilding() )
        {
            $this->doRequestBuilding();
        }
        else
        {
            parent::request();
        }
    }

    // /FUNCTIONS


}

?>