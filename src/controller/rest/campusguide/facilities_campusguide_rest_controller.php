<?php

class FacilitiesCampusguideRestController extends StandardCampusguideRestController
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
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see StandardCampusguideRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getFacilityDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
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
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new FacilityListModel();
    }

    // ... /GET


    /**
     * Overwrite beforeIsAdd function
     *
     * @see StandardCampusguideRestController::beforeIsAdd()
     */
    protected function beforeIsAdd()
    {
        // Set empty foreign model
        $this->setForeignModel( FacilityFactoryModel::createFacility( "Empty Facility" ) );
    }

    // /FUNCTIONS


}

?>