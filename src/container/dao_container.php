<?php

class DaoContainer extends ClassCore
{

    // VARIABLES


    /**
     * @var ErrorDao
     */
    protected $errorDao;

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
     * @var GroupScheduleDao
     */
    protected $groupScheduleDao;
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
        $this->setErrorDao( new ErrorDbDao( $dbApi ) );

        $this->setFacilityDao( new FacilityDbDao( $dbApi ) );
        $this->setBuildingDao( new BuildingDbDao( $dbApi ) );
        $this->setSectionBuildingDao( new SectionBuildingDbDao( $dbApi ) );
        $this->setElementBuildingDao( new ElementBuildingDbDao( $dbApi ) );
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
     * @return ErrorDao
     */
    public function getErrorDao()
    {
        return $this->errorDao;
    }

    /**
     * @param ErrorDao $errorDao
     */
    public function setErrorDao( ErrorDao $errorDao )
    {
        $this->errorDao = $errorDao;
    }

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
        return $this->groupScheduleDao;
    }

    /**
     * @param GroupScheduleDao $groupScheduleDao
     */
    public function setGroupScheduleDao( GroupScheduleDao $groupScheduleDao )
    {
        $this->groupScheduleDao = $groupScheduleDao;
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