<?php

class BuildingAppCampusguideMainController extends AppCampusguideMainController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    const PAGE_OVERVIEW = "overview";

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
     * @see AppCampusguideMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "BuildingAppCampusguideMainController";
    }

    /**
     * @see AppCampusguideMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "BuildingAppCampusguideMainView";
    }

    /**
     * @see AppCampusguideMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return BuildingAppCampusguideMainView::$ID_APP_WRAPPER;
    }

    /**
     * @see CampusguideMainController::getControllerName()
     */
    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    protected function getTitle()
    {
        return sprintf( "%s - %s - %s", $this->getBuilding()->getName(), "Building", parent::getTitle() );
    }

    // ... /GET


    /**
     * @see Controller::request()
     */
    public function request()
    {

        try
        {

            // Building
            if ( self::getId() )
            {

                // Set Building
                $this->setBuilding( $this->getBuildingDao()->get( self::getId() ) );

                // Building must exist
                if ( !$this->getBuilding() )
                {
                    throw new BadrequestException( sprintf( "Building \"%s\" does not exist", self::getId() ) );
                }

                // Set Floors
                $this->setFloors(
                        $this->getCampusguideHandler()->getFloorBuildingDao()->getForeign(
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
     * @see CmsCampusguideMainController::after()
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