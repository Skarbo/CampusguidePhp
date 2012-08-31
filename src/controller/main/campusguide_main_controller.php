<?php

abstract class CampusguideMainController extends MainController
{

    // VARIABLES


    // ... DAO


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;
    /**
     * @var FacilityDao
     */
    private $facilityDao;
    /**
     * @var SectionBuildingDao
     */
    private $sectionBuildingDao;
    /**
     * @var BuildingDao
     */
    private $buildingDao;
    /**
     * @var ElementBuildingDao
     */
    private $elementBuildingDao;
    /**
     * @var TypeElementBuildingDao
     */
    private $typeElementBuildingDao;
    /**
     * @var GroupTypeElementBuildingDao
     */
    private $groupTypeElementBuildingDao;
    /**
     * @var FloorBuildingDao
     */
    private $floorBuildingDao;
    /**
     * @var QueueDao
     */
    private $queueDao;

    // ... /DAO


    /**
     * @var array
     */
    private $errors = array ();

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setCampusguideHandler( new CampusguideHandler( $this->getDbApi() ) );

        $this->setFacilityDao( new FacilityDbDao( $this->getDbApi() ) );
        $this->setBuildingDao( new BuildingDbDao( $this->getDbApi() ) );
        $this->setSectionBuildingDao( new SectionBuildingDbDao( $this->getDbApi() ) );
        $this->setElementBuildingDao( new ElementBuildingDbDao( $this->getDbApi() ) );
        $this->setTypeElementBuildingDao( new TypeElementBuildingDbDao( $this->getDbApi() ) );
        $this->setGroupTypeElementBuildingDao( new TypeElementBuildingDbDao( $this->getDbApi() ) );
        $this->setFloorBuildingDao( new FloorBuildingDbDao( $this->getDbApi() ) );
        $this->setQueueDao( new QueueDbDao( $this->getDbApi() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return CampusguideHandler
     */
    protected function getCampusguideHandler()
    {
        return $this->campusguideHandler;
    }

    /**
     * @param CampusguideHandler $campusguideHandler
     */
    private function setCampusguideHandler( CampusguideHandler $campusguideHandler )
    {
        $this->campusguideHandler = $campusguideHandler;
    }

    // ... ... DAO


    /**
     * @return FacilityDao
     */
    public function getFacilityDao()
    {
        return $this->facilityDao;
    }

    /**
     * @param FacilityDao $facilityDao
     */
    public function setFacilityDao( FacilityDao $facilityDao )
    {
        $this->facilityDao = $facilityDao;
    }

    /**
     * @return BuildingDao
     */
    public function getBuildingDao()
    {
        return $this->buildingDao;
    }

    /**
     * @param BuildingDao $buildingDao
     */
    public function setBuildingDao( BuildingDao $buildingDao )
    {
        $this->buildingDao = $buildingDao;
    }

    /**
     * @return SectionBuildingDao
     */
    public function getSectionBuildingDao()
    {
        return $this->sectionBuildingDao;
    }

    /**
     * @param SectionBuildingDao $sectionBuildingDao
     */
    public function setSectionBuildingDao( SectionBuildingDao $sectionBuildingDao )
    {
        $this->sectionBuildingDao = $sectionBuildingDao;
    }

    /**
     * @return ElementBuildingDao
     */
    public function getElementBuildingDao()
    {
        return $this->elementBuildingDao;
    }

    /**
     * @param ElementBuildingDao $roomBuildingDao
     */
    public function setElementBuildingDao( ElementBuildingDao $roomBuildingDao )
    {
        $this->elementBuildingDao = $roomBuildingDao;
    }

    /**
     * @return TypeElementBuildingDao
     */
    public function getTypeElementBuildingDao()
    {
        return $this->typeElementBuildingDao;
    }

    /**
     * @param TypeElementBuildingDao $elementBuildingDao
     */
    public function setTypeElementBuildingDao( TypeElementBuildingDao $elementBuildingDao )
    {
        $this->typeElementBuildingDao = $elementBuildingDao;
    }

    /**
     * @return GroupTypeElementBuildingDao
     */
    public function getGroupTypeElementBuildingDao()
    {
        return $this->groupTypeElementBuildingDao;
    }

    /**
     * @param GroupTypeElementBuildingDao $groupTypeElementBuildingDao
     */
    public function setGroupTypeElementBuildingDao( GroupTypeElementBuildingDao $groupTypeElementBuildingDao )
    {
        $this->groupTypeElementBuildingDao = $groupTypeElementBuildingDao;
    }

    /**
     * @return FloorBuildingDao
     */
    public function getFloorBuildingDao()
    {
        return $this->floorBuildingDao;
    }

    /**
     * @param FloorBuildingDao $floorBuildingDao
     */
    public function setFloorBuildingDao( FloorBuildingDao $floorBuildingDao )
    {
        $this->floorBuildingDao = $floorBuildingDao;
    }

    /**
     * @return QueueDao
     */
    public function getQueueDao()
    {
        return $this->queueDao;
    }

    /**
     * @param QueueDao $queueDao
     */
    public function setQueueDao( QueueDao $queueDao )
    {
        $this->queueDao = $queueDao;
    }

    // /... ... DAO


    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return array:
     */
    public function getErrors()
    {
        return $this->errors;
    }

    // ... /GET


    // ... ADD


    protected function addJavascriptMap()
    {

        $code = <<<EOD
$(document).ready(function() {
	var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "%s";
    document.body.appendChild(script);
} );

function initMap()
{
    eventHandler.handle(new MapinitEvent());
}
EOD;

        $this->addJavascriptCode(
                sprintf( $code, Resource::javascript()->getGoogleMapsApiUrl( Resource::getGoogleApiKey(), "initMap" ) ) );

    }

    /**
     * @param AbstractException $exception
     */
    public function addError( AbstractException $exception )
    {
        $this->errors[] = $exception;
    }

    // ... /ADD


    // ... GET


    /**
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see MainController::getTitle()
     */
    protected function getTitle()
    {
        return "Campusguide";
    }

    /**
     * @return string Controller name
     */
    public abstract function getControllerName();

    // ... /GET


    // /FUNCTIONS


}

?>