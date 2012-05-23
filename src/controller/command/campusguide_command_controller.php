<?php

abstract class CampusguideCommandController extends CommandController implements CampusguideInterfaceController
{

    // VARIABLES


    const URI_COMMAND = 1;
    const URI_ID = 2;

    public static $ID_SPLITTER = "_";

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

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $db_api, AbstractDefaultLocale $locale, View $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );

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

    // ... ... /DAO


    // ... /GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return int Id given in URI, null if none given
     */
    protected static function getId()
    {
        return Core::arrayAt( self::getIds(), 0, null );
    }

    /**
     * @return int Id's given in URI
     */
    protected static function getIds()
    {
        return array_filter(
                array_map(
                        function ( $val )
                        {
                            return intval( $val );
                        }, explode( self::$ID_SPLITTER, self::getURI( self::URI_ID ) ) ) );
    }

    /**
     * @return string URI command
     */
    protected static function getCommand()
    {
        return self::getURI( self::URI_COMMAND );
    }

    // ... ... /STATIC


    // ... /GET


    // /FUNCTIONS


}