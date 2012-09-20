<?php

class CampusguideHandler extends Handler
{

    // VARIABLES


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


    public function __construct( DbApi $dbApi )
    {
        $this->setFacilityDao( new FacilityDbDao( $dbApi ) );
        $this->setBuildingDao( new BuildingDbDao( $dbApi ) );
        $this->setSectionBuildingDao( new SectionBuildingDbDao( $dbApi ) );
        $this->setElementBuildingDao( new ElementBuildingDbDao( $dbApi ) );
        $this->setTypeElementBuildingDao( new TypeElementBuildingDbDao( $dbApi ) );
        $this->setGroupTypeElementBuildingDao( new GroupTypeElementBuildingDbDao( $dbApi ) );
        $this->setFloorBuildingDao( new FloorBuildingDbDao( $dbApi ) );
        $this->setQueueDao( new QueueDbDao( $dbApi ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


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

    // /FUNCTIONS


}

?>