<?php

class BuildingAppCampusguideMainController extends AppCampusguideMainController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "building";

    /**
     * @var BuildingModel
     */
    private $building;

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

    // /FUNCTIONS


}

?>