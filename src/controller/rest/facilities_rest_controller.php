<?php

class FacilitiesRestController extends StandardRestController
{

    // VARIABLES

    public static $CONTROLLER_NAME = "facilities";

    /**
     * @var FacilityValidator
     */
    private $facilityValidator;

    // /VARIABLES


    // FUNCTIONS


    // ... CONSTRUCT


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

        $this->setFacilityValidator( new FacilityValidator( $this->getLocale() ) );
    }

    // ... /CONSTRUCT


    // ... GETTERS/SETTERS


    /**
     * @return FacilityValidator
     */
    public function getFacilityValidator()
    {
        return $this->facilityValidator;
    }

    /**
     * @param FacilityValidator $facilityValidator
     */
    public function setFacilityValidator( FacilityValidator $facilityValidator )
    {
        $this->facilityValidator = $facilityValidator;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see AbstractController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see StandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getFacilityDao();
    }

    /**
     * @see StandardRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getDaoContainer()->getBuildingDao();
    }

    /**
     * @see StandardRestController::getModelPost()
     */
    protected function getModelPost()
    {
        // Create Facility
        $facility = new FacilityModel( self::getPostObject() );

        // Validate Avademy
        $this->getFacilityValidator()->doValidate( $facility, "Facility is not validate" );

        return $facility;
    }

    /**
     * @see StandardRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new FacilityListModel();
    }

    // ... /GET


    /**
     * Overwrite beforeIsAdd function
     *
     * @see StandardRestController::beforeIsAdd()
     */
    protected function beforeIsAdd()
    {
        // Set empty foreign model
        $this->setForeignModel( FacilityFactoryModel::createFacility( "Empty Facility" ) );
    }

    // /FUNCTIONS


}

?>