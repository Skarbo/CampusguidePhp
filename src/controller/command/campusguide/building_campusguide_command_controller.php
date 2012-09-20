<?php

class BuildingCampusguideCommandController extends CampusguideCommandController
{

    // VARIABLES


    const URI_QUEUE = 3;

    const COMMAND_SAVEOVERVIEW = "saveoverview";

    public static $CONTROLLER_NAME = "building";

    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var QueueModel
     */
    private $queue;

    // /VARIABLES


    // CONSTRUCTOR


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
     * @return QueueModel
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param QueueModel $queue
     */
    public function setQueue( QueueModel $queue )
    {
        $this->queue = $queue;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return int Queue id given in URI, null if none given
     */
    protected static function getQueueId()
    {
        return self::getURI( self::URI_QUEUE );
    }

    // ... ... /STATIC


    // ... /GET


    // ... IS


    /**
     * @return boolean True if command is save overview
     */
    protected function isCommandSaveoverview()
    {
        return self::getCommand() == self::COMMAND_SAVEOVERVIEW && self::isPost() && self::getId();
    }

    // ... /IS


    // ... DO


    /**
     * Do command save overview
     *
     * @throw BadrequestException
     */
    private function doCommandSaveoverview()
    {

        // Building width/height
        $width = BuildingCampusguideImageResource::BUILDING_OVERVIEW_WIDTH_DEFAULT;
        $height = BuildingCampusguideImageResource::BUILDING_OVERVIEW_HEIGHT_DEFAULT;
        if ( $this->getQueue() )
        {
            $size = Core::arrayAt( $this->getQueue()->getArguments(), "size", array () );
            list ( $width, $height ) = $size;
        }

        // Retrieve image data
        $imageData = self::getPostRaw();

        // Remove headers
        $filteredData = strpos( $imageData, "," ) !== false ? substr( $imageData,
                strpos( $imageData, "," ) + 1 ) : null;

        // Filtered data must not be empty
        if ( !$filteredData )
        {
            throw new BadrequestException( "Invalid image data given" );
        }

        // Decode filtered data
        $unencodedData = base64_decode( $filteredData );

        // Generate building image path
        $buildingImagePath = Resource::image()->campusguide()->building()->getBuildingOverview(
                $this->getBuilding()->getId(), $this->getMode(), $width, $height );

        // Save file
        $fp = fopen( $buildingImagePath, 'wb' );
        fwrite( $fp, $unencodedData );
        fclose( $fp );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

        // Delete Queue if given
        if ( $this->getQueue() )
        {
            $this->getCampusguideHandler()->getQueueDao()->remove( $this->getQueue()->getId() );
        }

    }

    // ... /DO


    /**
     * @see Controller::before()
     * @throws BadrequestException
     */
    public function before()
    {

        // Command is save overview
        if ( $this->isCommandSaveoverview() )
        {
            // Set Building
            $this->setBuilding( $this->getCampusguideHandler()->getBuildingDao()->get( self::getId() ) );

            // Building must exist
            if ( !$this->getBuilding() )
            {
                throw new BadrequestException( sprintf( "Building \"%s\" does not exist", self::getId() ) );
            }

            // Set Queue
            $this->setQueue( $this->getCampusguideHandler()->getQueueDao()->get( self::getQueueId() ) );
        }

    }

    /**
     * @see Controller::request()
     */
    public function request()
    {

        DebugHandler::doDebug( DebugHandler::LEVEL_LOW,
                new DebugException( "BuildingCampusguideCommandController request", self::getCommand(),
                        self::getRequestMethod(), self::getIds(), self::getId() ) );
        // Command save overview
        if ( $this->isCommandSaveoverview() )
        {
            $this->doCommandSaveoverview();
        }
        // Unknown request
        else
        {
            throw new BadrequestException(
                    sprintf( "Invalid request. Command \"%s\", request method \"%s\"", self::getCommand(),
                            self::getRequestMethod() ) );
        }

    }


    // /FUNCTIONS


}

?>