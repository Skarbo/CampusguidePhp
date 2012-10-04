<?php

class CampusguideHandler extends Handler
{

    // VARIABLES


    /**
     * @var FacilityDao
     */
    protected $facilityDao;
    /**
     * @var SectionBuildingDao
     */
    protected $sectionBuildingDao;
    /**
     * @var BuildingDao
     */
    protected $buildingDao;
    /**
     * @var ElementBuildingDao
     */
    protected $elementBuildingDao;
    /**
     * @var TypeElementBuildingDao
     */
    protected $typeElementBuildingDao;
    /**
     * @var GroupTypeElementBuildingDao
     */
    protected $groupTypeElementBuildingDao;
    /**
     * @var FloorBuildingDao
     */
    protected $floorBuildingDao;
    /**
     * @var QueueDao
     */
    protected $queueDao;

    /**
     * @var EntryScheduleDao
     */
    protected $entryScheduleDao;
    /**
     * @var FacultyScheduleDao
     */
    protected $facultyScheduleDao;
    /**
     * @var ProgramScheduleDao
     */
    protected $programScheduleDao;
    /**
     * @var RoomScheduleDao
     */
    protected $roomScheduleDao;
    /**
     * @var WebsiteScheduleDao
     */
    protected $websiteScheduleDao;

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

        $this->setEntryScheduleDao( new EntryScheduleDbDao( $dbApi ) );
        $this->setFacultyScheduleDao( new FacultyScheduleDbDao( $dbApi ) );
        $this->setGroupScheduleDao( new GroupScheduleDbDao( $dbApi ) );
        $this->setProgramScheduleDao( new ProgramScheduleDbDao( $dbApi ) );
        $this->setRoomScheduleDao( new RoomScheduleDbDao( $dbApi ) );
        $this->setWebsiteScheduleDao( new WebsiteScheduleDbDao( $dbApi ) );
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

    // ... SCHEDULE


    /**
     * @return EntryScheduleDao
     */
    public function getEntryScheduleDao()
    {
        return $this->entryScheduleDao;
    }

    /**
     * @param EntryScheduleDao $entryScheduleDao
     */
    public function setEntryScheduleDao( EntryScheduleDao $entryScheduleDao )
    {
        $this->entryScheduleDao = $entryScheduleDao;
    }

    /**
     * @return FacultyScheduleDao
     */
    public function getFacultyScheduleDao()
    {
        return $this->facultyScheduleDao;
    }

    /**
     * @param FacultyScheduleDao $facultyScheduleDao
     */
    public function setFacultyScheduleDao( FacultyScheduleDao $facultyScheduleDao )
    {
        $this->facultyScheduleDao = $facultyScheduleDao;
    }

    /**
     * @return GroupScheduleDao
     */
    public function getGroupScheduleDao()
    {
        return $this->groupTypeElementBuildingDao;
    }

    /**
     * @param GroupScheduleDao $groupTypeElementBuildingDao
     */
    public function setGroupScheduleDao( GroupScheduleDao $groupTypeElementBuildingDao )
    {
        $this->groupTypeElementBuildingDao = $groupTypeElementBuildingDao;
    }

    /**
     * @return ProgramScheduleDao
     */
    public function getProgramScheduleDao()
    {
        return $this->programScheduleDao;
    }

    /**
     * @param ProgramScheduleDao $programScheduleDao
     */
    public function setProgramScheduleDao( ProgramScheduleDao $programScheduleDao )
    {
        $this->programScheduleDao = $programScheduleDao;
    }

    /**
     * @return RoomScheduleDao
     */
    public function getRoomScheduleDao()
    {
        return $this->roomScheduleDao;
    }

    /**
     * @param RoomScheduleDao $roomScheduleDao
     */
    public function setRoomScheduleDao( RoomScheduleDao $roomScheduleDao )
    {
        $this->roomScheduleDao = $roomScheduleDao;
    }

    /**
     * @return WebsiteScheduleDao
     */
    public function getWebsiteScheduleDao()
    {
        return $this->websiteScheduleDao;
    }

    /**
     * @param WebsiteScheduleDao $websiteScheduleDao
     */
    public function setWebsiteScheduleDao( WebsiteScheduleDao $websiteScheduleDao )
    {
        $this->websiteScheduleDao = $websiteScheduleDao;
    }

    // ... /SCHEDULE


    // /FUNCTIONS


}

?>