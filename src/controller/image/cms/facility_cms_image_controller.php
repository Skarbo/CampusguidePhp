<?php

class FacilityCmsImageController extends CmsImageController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "facility";
    private static $URL_FACILITY_MAP = "http://maps.googleapis.com/maps/api/staticmap?size=200x100&markers=size:small|color:red|%s&sensor=false";

    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var BuildingListModel
     */
    private $buildings;
    /**
     * @var string
     */
    private $facilityMapUrl;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->setBuildings( new BuildingListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return FacilityModel
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * @param FacilityModel $facility
     */
    public function setFacility( FacilityModel $facility )
    {
        $this->facility = $facility;
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
     * @return string
     */
    private function getFacilityMapUrl()
    {
        return $this->facilityMapUrl;
    }

    /**
     * @param string $facilityMapUrl
     */
    private function setFacilityMapUrl( $facilityMapUrl )
    {
        $this->facilityMapUrl = $facilityMapUrl;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see ImageController::getLastModified()
     */
    public function getLastModified()
    {
        return max( parent::getLastModified(), filemtime( __FILE__ ),
                $this->getFacility() ? $this->getFacility()->getLastModified() : null,
                $this->getBuildings()->getLastModified(), $this->getFacilityImageModified() );
    }

    /**
     * @return integer Unixtime last time modified, null if not exist
     */
    private function getFacilityImageModified()
    {

        // Get image size
        list ( $width, $height ) = self::getSizeWidthSize();

        // Get Facility image path
        $facilityImage = Resource::image()->facility()->getFacilityMap(
                $this->getFacility()->getId(), $this->getMode(), $width, $height );

        // Return modified time if file exist
        if ( file_exists( $facilityImage ) )
        {
            return filemtime( $facilityImage );
        }

        // Return null if file does not exist
        return null;
    }

    /**
     * @see CmsImageController::getImage()
     */
    public function getImage()
    {

        // Get image size
        list ( $width, $height ) = self::getSizeWidthSize();

        // Get Facility image
        $facilityImage = Resource::image()->facility()->getFacilityMap(
                $this->getFacility()->getId(), $this->getMode(), $width, $height );

        // Return Facility image if exist
        if ( file_exists( $facilityImage ) )
        {
            return $facilityImage;
        }

        // Return default Facility image
        return Resource::image()->facility()->getDefaultFacilityMap( $width, $height );

    }

    // ... /GET


    // ... IS


    /**
     * @return boolean True if cache Facility map
     */
    private function isFacilityMapCache()
    {

        // Don't cache if no Facility Buildings
        if ( $this->getBuildings()->isEmpty() )
        {
            return false;
        }

        // Get Facility image modified
        $facilityImageModified = $this->getFacilityImageModified();

        // Return true if modified or never cached
        return !$facilityImageModified || $facilityImageModified < $this->getFacility()->getLastModified() || $facilityImageModified < $this->getBuildings()->getLastModified();

    }

    // ... /IS


    // ... CREATE


    /**
     * @return string Facility Map URL
     */
    private function createFacilityMapUrl()
    {
        // Create markers
        $markers = array ();
        for ( $this->getBuildings()->rewind(); $this->getBuildings()->valid(); $this->getBuildings()->next() )
        {
            $building = $this->getBuildings()->current();

            if ( $building->getAddress() || $building->getLocation() )
            {
                $markers[] = $building->getLocation() ? implode( BuildingUtil::$SPLITTER_LOCATION, $building->getLocation() ) : implode( ", ",
                        Core::empty_( $building->getAddress(), array () ) );
            }
        }

        // Get image size
        list ( $width, $height ) = self::getSizeWidthSize();

        // Return Facility map url
        return Resource::image()->facility()->getUrlFacilityMap( $markers, $width, $height );

    }

    // ... /CREATE


    // ... DO


    private function doCacheFacilityImage()
    {

        // Get Facility map URL
        $facilityMapUrl = $this->getFacilityMapUrl();

        // Get image size
        list ( $width, $height ) = self::getSizeWidthSize();

        // Get Facility map file path
        $facilityMapFile = Resource::image()->facility()->getFacilityMap(
                $this->getFacility()->getId(), $this->getMode(), $width, $height );

        try
        {

            // Cache Facility map
            $this->doCacheImage( $facilityMapFile, $facilityMapUrl );

        }
        catch ( Exception $exception )
        {

            // Log error
            ErrorHandler::doError(
                    new Exception(
                            sprintf( "Error while caching Facility image \"%s\": %s", $this->getFacility()->getId(),
                                    $exception->getMessage() ), $exception->getCode(), $exception ) );

        }

    }

    // ... /DO


    /**
     * @see AbstractController::before()
     */
    public function before()
    {

        // Set Facility
        $this->setFacility( $this->getDaoContainer()->getFacilityDao()->get( self::getIdURI() ) );

        // Facility must exist
        if ( !$this->getFacility() )
        {
            throw new BadrequestException( sprintf( "Facility \"%d\" does not exist", self::getIdURI() ) );
        }

        // Set Facility Buildings
        $this->setBuildings( $this->getDaoContainer()->getBuildingDao()->getForeign( array ( $this->getFacility()->getId() ) ) );

        // Set Facility map url
        $this->setFacilityMapUrl( $this->createFacilityMapUrl() );

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

        // Facility map cache
        if ( $this->isFacilityMapCache() )
        {

            // Cache Facility image
            $this->doCacheFacilityImage();

        }

    }

    // /FUNCTIONS


}

?>