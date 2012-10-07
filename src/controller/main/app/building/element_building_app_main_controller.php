<?php

class ElementBuildingAppMainController extends AppMainController implements ElementBuildingAppInterfaceView
{

    // VARIABLES


    public static $CONTROLLER_NAME = "element";

    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var FloorBuildingModel
     */
    private $floor;
    /**
     * @var ElementBuildingModel
     */
    private $element;

    // /VARIABLES


    // CONSTRUCTOR


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
     * @return FloorBuildingModel
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param FloorBuildingModel $floor
     */
    public function setFloor( FloorBuildingModel $floor )
    {
        $this->floor = $floor;
    }

    /**
     * @return ElementBuildingModel
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param ElementBuildingModel $element
     */
    public function setElement( ElementBuildingModel $element )
    {
        $this->element = $element;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see AppMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "ElementBuildingAppMainController";
    }

    /**
     * @see AppMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "ElementBuildingAppMainView";
    }

    /**
     * @see AppMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return ElementBuildingAppMainView::$ID_ELEMENT_PAGE_WRAPPER;
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
        return sprintf( "%s - %s - %s", $this->getElement()->getName(), "Element", parent::getTitle() );
    }

    // ... /GET


    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        try
        {
            if ( self::getId() )
            {
                $this->setElement( $this->getDaoContainer()->getElementBuildingDao()->get( self::getId() ) );

                if ( !$this->getElement() )
                {
                    throw new BadrequestException( sprintf( "Element \"%s\" does not exist", self::getId() ) );
                }

                $this->setFloor(
                        $this->getDaoContainer()->getFloorBuildingDao()->get( $this->getElement()->getFloorId() ) );
                $this->setBuilding(
                        $this->getDaoContainer()->getBuildingDao()->get( $this->getFloor()->getBuildingId() ) );
                $this->setFacility(
                        $this->getDaoContainer()->getFacilityDao()->get( $this->getBuilding()->getFacilityId() ) );
            }
            else
            {
                throw new BadrequestException( "Element not given" );
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