<?php

class BuildingAppMainController extends AppMainController implements BuildingAppInterfaceView
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    const PAGE_OVERVIEW = "overview";

    /**
     * @var FacilityModel
     */
    private $facility;
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

        $this->setFloors( new FloorBuildingListModel() );
        $this->facility = FacilityFactoryModel::createFacility( "" );
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
     * @return FloorBuildingListModel
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * @param FloorBuildingListModel $floors
     */
    public function setFloors( FloorBuildingListModel $floors )
    {
        $this->floors = $floors;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see AppMainController::getJavascriptController()
     */
    public function getJavascriptController()
    {
        return "BuildingAppMainController";
    }

    /**
     * @see AppMainController::getJavascriptView()
     */
    public function getJavascriptView()
    {
        return "BuildingAppMainView";
    }

    /**
     * @see AppMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return BuildingAppMainView::$ID_APP_WRAPPER;
    }

    /**
     * @see MainController::getControllerName()
     */
    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    protected function getTitle()
    {
        return sprintf( "%s - %s - %s", $this->getBuilding()->getName(), "Building", parent::getTitle() );
    }

    public function getFacility()
    {
        return $this->facility;
    }

    // ... /GET


    /**
     * @see AbstractController::request()
     */
    public function request()
    {

        try
        {

            // Building
            if ( self::getId() )
            {

                // Set Building
                $this->setBuilding( $this->getDaoContainer()->getBuildingDao()->get( self::getId() ) );

                // Building must exist
                if ( !$this->getBuilding() )
                {
                    throw new BadrequestException( sprintf( "Building \"%s\" does not exist", self::getId() ) );
                }

                // Set Facility
                $this->facility = $this->getDaoContainer()->getFacilityDao()->get(
                        $this->getBuilding()->getFacilityId() );

                // Set Floors
                $this->setFloors(
                        $this->getDaoContainer()->getFloorBuildingDao()->getForeign(
                                array ( $this->getBuilding()->getId() ) ) );

            }
            // Id must be given
            else
            {
                throw new BadrequestException( "Building not given" );
            }

        }
        catch ( BadrequestException $e )
        {
            $this->addError( $e );
        }

    }

    /**
     * @see CmsMainController::after()
     */
    public function after()
    {
        parent::after();

        // Add API's
        $this->addJavascriptFile( Resource::javascript()->getKineticApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJavascriptCanvasFile( $this->getMode() ) );
        $this->addJavascriptFile( Resource::javascript()->getHammerApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getHammerJqueryApiFile() );

    }

    // /FUNCTIONS


}

?>