<?php

class BuildingCmsCampusguideImageController extends CmsCampusguideImageController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    /**
     * @var QueueHandler
     */
    private $queueHandler;
    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var FloorBuildingListModel
     */
    private $floors;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->setQueueHandler( new QueueHandler( $this->getCampusguideHandler()->getQueueDao(), new QueueValidator( $this->getLocale() ) ) );

        $this->setFloors( new FloorBuildingListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return BuildingModel
     */
    private function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param BuildingModel $building
     */
    private function setBuilding( BuildingModel $building )
    {
        $this->building = $building;
    }

    /**
     * @return FloorBuildingListModel
     */
    private function getFloors()
    {
        return $this->floors;
    }

    /**
     * @param FloorBuildingListModel $floors
     */
    private function setFloors( FloorBuildingListModel $floors )
    {
        $this->floors = $floors;
    }

    /**
     * @return QueueHandler
     */
    public function getQueueHandler()
    {
        return $this->queueHandler;
    }

    /**
     * @param QueueHandler $queueHandler
     */
    public function setQueueHandler( QueueHandler $queueHandler )
    {
        $this->queueHandler = $queueHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see CampusguideImageController::getLastModified()
     */
    public function getLastModified()
    {
        return max( parent::getLastModified(), filemtime( __FILE__ ),
                $this->getBuilding() ? $this->getBuilding()->getLastModified() : null, $this->getImageLastModified() );
    }

    private function getImagePath()
    {

        list ( $width, $height ) = self::getSizeWidthSize();

        $imagePath = Resource::image()->campusguide()->building()->getBuildingOverview( $this->getBuilding()->getId(),
                $this->getMode(), $width, $height );

        return $imagePath;

    }

    public function getImage()
    {

        $imagePath = $this->getImagePath();

        if ( file_exists( $imagePath ) )
        {
            return $imagePath;
        }
        else
        {
            list ( $width, $height ) = self::getSizeWidthSize();
            return Resource::image()->campusguide()->building()->getDefaultBuildingOverview( $width, $height );
        }

    }

    /**
     * @return int Image last modified
     */
    private function getImageLastModified()
    {
        $image = $this->getImage();
        if ( file_exists( $image ) )
        {
            return filemtime( $image );
        }
        return null;
    }

    // ... /GET


    // ... DO


    private function doQueueCacheBuildingImage()
    {

        // Get image path
        $imagePath = $this->getImagePath();

        // Cache if image does not exist
        if ( !file_exists( $imagePath ) || filemtime( $imagePath ) < $this->getBuilding()->getLastModified() )
        {
            list ( $width, $height ) = self::getSizeWidthSize();

            // Delete image
            if ( file_exists( $imagePath ) )
            {
                @unlink( $imagePath );
            }

            // Must contain Floors
            if ( !$this->getFloors()->isEmpty() )
            {

                // Create Queue
                $queue = QueueFactoryModel::createBuildingQueue( $this->getBuilding()->getId(),
                        array ( "size" => array ( $width, $height ) ) );

                // Add Queue
                $this->getQueueHandler()->handle( $queue );

            }

        }

    }

    // ... /DO


    /**
     * @see Controller::before()
     */
    public function before()
    {

        // Set Building
        $this->setBuilding( $this->getCampusguideHandler()->getBuildingDao()->get( self::getId() ) );

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( sprintf( "Building \"%d\" does not exist", self::getId() ) );
        }

        // Set Floors
        $this->setFloors(
                $this->getCampusguideHandler()->getFloorBuildingDao()->getForeign(
                        array ( $this->getBuilding()->getId() ) ) );

    }

    /**
     * @see Controller::request()
     */
    public function request()
    {

        // Queue cache Building image
        $this->doQueueCacheBuildingImage();

    }

    // /FUNCTIONS


}

?>