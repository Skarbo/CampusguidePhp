<?php

class FloorsBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingfloors";

    public static $POST_OBJECTS = "objects";

    /**
     * @var FloorBuildingHandler
     */
    private $floorBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

        $this->setFloorBuildingHandler(
                new FloorBuildingHandler( $this->getCampusguideHandler()->getFloorBuildingDao(), new FloorBuildingValidator( $this->getLocale() ) ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @return FloorBuildingHandler
     */
    public function getFloorBuildingHandler()
    {
        return $this->floorBuildingHandler;
    }

    /**
     * @param FloorBuildingHandler $floorHandler
     */
    public function setFloorBuildingHandler( FloorBuildingHandler $floorHandler )
    {
        $this->floorBuildingHandler = $floorHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see StandardCampusguideRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getCampusguideHandler()->getFloorBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getCampusguideHandler()->getBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
     */
    protected function getModelPost()
    {
        $objectPost = $this->getPostObject();

        $floor = FloorBuildingFactoryModel::createFloorBuilding( $this->getForeignModel()->getId(),
                Core::arrayAt( $objectPost, "name" ), Core::arrayAt( $objectPost, "order" ),
                Core::arrayAt( $objectPost, "coordinates" ), Core::arrayAt( $objectPost, "main" ) );

        return $floor;
    }

    /**
     * @return FloorBuildingListModel
     */
    private static function getModelListPost()
    {
        $floors = new FloorBuildingListModel();

        foreach ( Core::arrayAt( self::getPost(), self::$POST_OBJECTS, array () ) as $floorPost )
        {
            $floors->add( new FloorBuildingModel( $floorPost ) );
        }

        return $floors;
    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new FloorBuildingListModel();
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if command is edit single
     */
    private static function isEditSingleCommand()
    {
        return self::isEditCommand() && Core::arrayAt( self::getPost(), self::$POST_FLOOR, false );
    }

    /**
     * @return boolean True if command is edit multiple
     */
    private static function isEditMultipleCommand()
    {
        return self::isEditCommand() && Core::arrayAt( self::getPost(), self::$POST_OBJECTS, false );
    }

    // ... /IS


    // ... DO


    //     protected function doAddCommand()
    //     {


    //         // Retrieve Floor from post
    //         $floor = $this->getModelPost();


    //         // Handle Floor Add
    //         $floorAdded = $this->getFloorBuildingHandler()->handleAddFloor( $this->getForeignModel()->getId(),
    //                 $floor );


    //         // Set added Floor
    //         $this->setModel( $floorAdded );


    //         // Set Floor list
    //         $this->setModelList( $this->getStandardDao()->getForeign( $this->getForeignModel()->getId() ) );


    //         // Set status code
    //         $this->setStatusCode( self::STATUS_CREATED );


    //     }


    //     protected function doEditCommand()
    //     {


    //         // Edit multiple
    //         if ( self::isEditMultipleCommand() )
    //         {


    //             // Retrieve Floors from post
    //             $floors = $this->getModelListPost();


    //             // Handle Floor edit
    //             $floorsEdited = $this->getFloorBuildingHandler()->handleEditFloors(
    //                     $this->getModel()->getForeignId(), $floors );


    //             // Set edited Floor
    //             $this->setModelList( $floorsEdited );


    //             // Set status code
    //             $this->setStatusCode( self::STATUS_CREATED );


    //         }
    //         // Edit single
    //         else
    //         {
    //             parent::doEditCommand();
    //         }


    //     }


    // ... /DO


    // /FUNCTIONS


}

?>