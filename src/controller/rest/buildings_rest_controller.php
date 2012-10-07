<?php

class BuildingsRestController extends StandardRestController
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
        return $this->getDaoContainer()->getBuildingDao();
    }

    /**
     * @see StandardRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getDaoContainer()->getFacilityDao();
    }

    /**
     * @see StandardRestController::getModelPost()
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
     * @see StandardRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new BuildingListModel();
    }

    // ... /GET


    // /FUNCTIONS


}

?>