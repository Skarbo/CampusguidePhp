<?php

class BuildingsCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES

    public static $CONTROLLER_NAME = "buildings";

    /**
     * @var BuildingValidator
     */
    private $buildingValidator;

    // /VARIABLES


    // FUNCTIONS


    // ... CONSTRUCT


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

        $this->setBuildingValidator( new BuildingValidator( $this->getLocale() ) );
    }

    // ... /CONSTRUCT


    // ... GETTERS/SETTERS


    /**
     * @return BuildingValidator
     */
    public function getBuildingValidator()
    {
        return $this->buildingValidator;
    }

    /**
     * @param BuildingValidator $buildingValidator
     */
    public function setBuildingValidator( BuildingValidator $buildingValidator )
    {
        $this->buildingValidator = $buildingValidator;
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
        return $this->getBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getFacilityDao();
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
     */
    protected function getModelPost()
    {
        // Create Building
        $building = new BuildingModel( self::getPostObject() );

        // Validate Building
        $this->getBuildingValidator()->doValidate( $building, "Building is not valid" );

        return $building;
    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new BuildingListModel();
    }

    // ... /GET


    // /FUNCTIONS


}

?>