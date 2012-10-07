<?php

class BuildingCmsImageController extends CmsImageController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    public static $TYPE_OVERVIEW = "overview";
    public static $TYPE_MAP = "map";

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
    /**
     * @var string
     */
    private $buildingMapUrl;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->setQueueHandler(
                new QueueHandler( $this->getDaoContainer(),
                        new QueueValidator( $this->getLocale() ) ) );

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
     * @see ImageController::getLastModified()
     */
    public function getLastModified()
    {
        return max( parent::getLastModified(), filemtime( __FILE__ ),
                $this->getBuilding() ? $this->getBuilding()->getLastModified() : null, $this->getImageLastModified() );
    }

    private function getImagePath()
    {

        list ( $width, $height ) = self::getSizeWidthSize();

        switch ( self::getTypeURI() )
        {
            case self::$TYPE_MAP :
                $imagePath = Resource::image()->building()->getBuildingMap(
                        $this->getBuilding()->getId(), $this->getMode(), $width, $height );
                break;

            default :
                $imagePath = Resource::image()->building()->getBuildingOverview(
                        $this->getBuilding()->getId(), $this->getMode(), $width, $height );
                break;
        }

        return $imagePath;

    }

    public function getImage()
    {
        $imagePath = $this->getImagePath();
DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "Get image", $imagePath ) );
        if ( file_exists( $imagePath ) )
        {
            return $imagePath;
        }
        else
        {
            list ( $width, $height ) = self::getSizeWidthSize();

            switch ( self::getTypeURI() )
            {
                case self::$TYPE_MAP :
                    return Resource::image()->building()->getBuildingMapDefault( $width, $height );

                default :
                    return Resource::image()->building()->getBuildingOverviewDefault( $width, $height );
            }
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

    /**
     * @return integer Unixtime last time modified, null if not exist
     */
    private function getBuildingMapModified()
    {
        list ( $width, $height ) = self::getSizeWidthSize();

        $buildingMapImage = Resource::image()->building()->getBuildingMap(
                $this->getBuilding()->getId(), $this->getMode(), $width, $height );

        if ( file_exists( $buildingMapImage ) )
        {
            return filemtime( $buildingMapImage );
        }
        return null;
    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if cache Building map
     */
    private function isBuildingMapCache()
    {
        // Don't cache if no Building location or position
        $location = $this->getBuilding()->getLocation();
        $position = Core::arrayAt( $this->getBuilding()->getPosition(), 3, array () );
        if ( empty( $location ) && empty( $position ) )
        {
            return false;
        }

        $buildingMapModified = $this->getBuildingMapModified();

        // Return true if modified or never cached
        return !$buildingMapModified || $buildingMapModified < $this->getBuilding()->getLastModified();
    }

    // ... /IS


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

    private function doCacheBuildingMap()
    {
        if ( !$this->isBuildingMapCache() )
            return;

        list ( $width, $height ) = self::getSizeWidthSize();

        $buildingMapFile = Resource::image()->building()->getBuildingMap( $this->getBuilding()->getId(),
                $this->getMode(), $width, $height );

        try
        {
            $this->doCacheImage( $buildingMapFile, $this->buildingMapUrl );
        }
        catch ( Exception $exception )
        {
            ErrorHandler::doError(
                    new Exception(
                            sprintf( "Error while caching Building map image \"%s\" \"%s\": %s",
                                    $this->getBuilding()->getId(), $buildingMapFile, $exception->getMessage() ),
                            $exception->getCode(), $exception ) );
        }

    }

    // ... /DO


    // ... CREATE


    /**
     * @return string Building Map URL
     */
    private function createBuildingMapUrl()
    {
        $location = $this->getBuilding()->getLocation();
        $positionCenter = Core::arrayAt( $this->getBuilding()->getPosition(), 3, array () );
        $coordinates = !empty( $positionCenter ) ? $positionCenter : $location;

        if ( empty( $coordinates ) )
            return null;

        list ( $width, $height ) = self::getSizeWidthSize();

        return Resource::image()->building()->getBuildingMapUrl( $coordinates, $width, $height );
    }

    // ... /CREATE


    /**
     * @see AbstractController::before()
     */
    public function before()
    {

        // Set Building
        $this->setBuilding( $this->getDaoContainer()->getBuildingDao()->get( self::getIdURI() ) );

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( sprintf( "Building \"%d\" does not exist", self::getIdURI() ) );
        }

        // Set Floors
        $this->setFloors(
                $this->getDaoContainer()->getFloorBuildingDao()->getForeign(
                        array ( $this->getBuilding()->getId() ) ) );

        // Set Building map url
        $this->buildingMapUrl = $this->createBuildingMapUrl();

    }

    /**
     * @see AbstractController::request()
     */
    public function request()
    {

    }

    /**
     * @see AbstractController::destroy()
     */
    public function destroy()
    {
        switch ( self::getTypeURI() )
        {
            case self::$TYPE_MAP :
                $this->doCacheBuildingMap();
                break;

            default :
                $this->doQueueCacheBuildingImage();
                break;
        }
    }

    // /FUNCTIONS


}

?>