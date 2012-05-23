<?php

class BuildingCmsCampusguideImageController extends CmsCampusguideImageController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    /**
     * @var QueueDao
     */
    private $queueDao;
    /**
     * @var QueueHandler
     */
    private $queueHandler;
    /**
     * @var BuildingModel
     */
    private $building;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $db_api, AbstractDefaultLocale $locale, View $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );
        $this->setQueueDao( new QueueDbDao( $this->getDbApi() ) );
        $this->setQueueHandler( new QueueHandler( $this->getQueueDao(), new QueueValidator( $this->getLocale() ) ) );
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
     * @return QueueDao
     */
    public function getQueueDao()
    {
        return $this->queueDao;
    }

    /**
     * @param QueueDao $queueDao
     */
    public function setQueueDao( QueueDao $queueDao )
    {
        $this->queueDao = $queueDao;
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

            // Create Queue
            $queue = QueueFactoryModel::createBuildingQueue( $this->getBuilding()->getId(),
                    array ( "size" => array ( $width, $height ) ) );

            // Add Queue
            $this->getQueueHandler()->handle( $queue );

        }

    }

    // ... /DO


    /**
     * @see Controller::before()
     */
    public function before()
    {

        // Set Building
        $this->setBuilding( $this->getBuildingDao()->get( self::getId() ) );

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( sprintf( "Building \"%d\" does not exist", self::getId() ) );
        }

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