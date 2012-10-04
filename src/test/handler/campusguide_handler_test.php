<?php

class CampusguideHandlerTest extends CampusguideHandler
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function removeAll()
    {
        $this->facilityDao->removeAll();
        $this->buildingDao->removeAll();
        $this->sectionBuildingDao->removeAll();
        $this->elementBuildingDao->removeAll();
        $this->typeElementBuildingDao->removeAll();
        $this->groupTypeElementBuildingDao->removeAll();
        $this->getFloorBuildingDao()->removeAll();
        $this->getQueueDao()->removeAll();

        $this->getWebsiteScheduleDao()->removeAll();
        $this->getEntryScheduleDao()->removeAll();
        $this->getFacultyScheduleDao()->removeAll();
        $this->getGroupScheduleDao()->removeAll();
        $this->getProgramScheduleDao()->removeAll();
        $this->getRoomScheduleDao()->removeAll();
    }

    // ... CREATE


    /**
     * @return FacilityModel
     */
    public static function createFacilityTest()
    {
        $facility = FacilityFactoryModel::createFacility( "Test Facility" );
        return $facility;
    }

    /**
     * @return BuildingModel
     */
    public static function createBuildingTest( $facilityId )
    {
        $building = BuildingFactoryModel::createBuilding( "Test Building", $facilityId,
                array ( array ( 100, 200 ), array ( 300, 400 ) ) );
        return $building;
    }

    /**
     * @return FloorBuildingModel
     */
    public static function createFloorBuildingTest( $buildingId )
    {
        $floorBuilding = FloorBuildingFactoryModel::createFloorBuilding( $buildingId, "Test Floor", 0,
                array ( array ( array ( 100, 200, "L" ), array ( 300, 400, "L" ) ) ) );
        return $floorBuilding;
    }

    /**
     * @return ElementBuildingModel
     */
    public static function createElementBuildingTest( $floorId )
    {
        $elementBuilding = ElementBuildingFactoryModel::createElementBuilding( $floorId, "Test Room",
                array ( array ( array ( 100, 200, "L" ), array ( 300, 400, "L" ) ) ) );
        return $elementBuilding;
    }

    /**
     * @return TypeElementBuildingModel
     */
    public static function createTypeElementBuildingTest( $groupId )
    {
        $typeElementBuilding = TypeElementBuildingFactoryModel::createTypeElementBuilding( $groupId,
                "Test Element Building", "icon1" );
        return $typeElementBuilding;
    }

    /**
     * @return GroupTypeElementBuildingModel
     */
    public static function createGroupTypeElementBuildingTest()
    {
        $groupTypeElementBuilding = GroupTypeElementBuildingFactoryModel::createGroupTypeElementBuilding(
                "Test Group Type Element Building" );
        return $groupTypeElementBuilding;
    }

    /**
     * @return SectionBuildingModel
     */
    public static function createSectionBuildingTest( $buildingId )
    {
        $sectionBuilding = SectionBuildingFactoryModel::createSectionBuilding( $buildingId, "Section Test",
                array ( array ( 100, 200 ), array ( 300, 400 ) ) );
        return $sectionBuilding;
    }

    public static function createQueueTest()
    {
        return QueueFactoryModel::createQueue( "test", QueueModel::PRIORITY_LOW );
    }

    // ... SCHEDULE


    /**
     * @return WebsiteScheduleModel
     */
    public static function createWebsiteScheduleTest()
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule( "http://test.com", "test" );
        return $website;
    }

    /**
     * @return RoomScheduleModel
     */
    public static function createRoomScheduleTest( $elementId = null )
    {
        $room = RoomScheduleFactoryModel::createRoomSchedule( $elementId, null, "Room Name", "Room Name Short" );
        return $room;
    }

    // ... /SCHEDULE


    // ... /CREATE


    // ... ADD


    /**
     * @return FacilityModel
     */
    public function addFacility()
    {
        $facility = self::createFacilityTest();
        $facility->setId( $this->facilityDao->add( $facility, null ) );
        return $facility;
    }

    /**
     * @return BuildingModel
     */
    public function addBuilding( $facilityId )
    {
        $building = self::createBuildingTest( $facilityId );
        $building->setId( $this->buildingDao->add( $building, $facilityId ) );
        return $building;
    }

    /**
     * @return SectionBuildingModel
     */
    public function addSection( $buildingId )
    {
        $section = self::createSectionBuildingTest( $buildingId );
        $section->setId( $this->sectionBuildingDao->add( $section, $buildingId ) );
        return $section;
    }

    /**
     * @return RoomBuildingModel
     */
    public function addElement( $floorId, ElementBuildingModel $element )
    {
        $element = $element ? $element : self::createElementBuildingTest( $floorId );
        $element->setId( $this->elementBuildingDao->add( $element, $floorId ) );
        return $element;
    }

    /**
     * @return TypeElementBuildingModel
     */
    public function addTypeElement( $elementTypeGroupId )
    {
        $typeElement = self::createTypeElementBuildingTest( $elementTypeGroupId );
        $typeElement->setId( $this->typeElementBuildingDao->add( $typeElement, $elementTypeGroupId ) );
        return $typeElement;
    }

    /**
     * @return GroupTypeElementBuildingModel
     */
    public function addGroupTypeElement()
    {
        $groupTypeElement = self::createGroupTypeElementBuildingTest();
        $groupTypeElement->setId( $this->groupTypeElementBuildingDao->add( $groupTypeElement, null ) );
        return $groupTypeElement;
    }

    /**
     * @return FloorBuildingModel
     */
    public function addFloor( $buildingId )
    {
        $floor = self::createFloorBuildingTest( $buildingId );
        $floor->setId( $this->getFloorBuildingDao()->add( $floor, $buildingId ) );
        return $floor;
    }

    /**
     * @return FloorBuildingModel
     */
    public function addQueue( QueueModel $queue = null )
    {
        $queue = $queue ? $queue : self::createQueueTest();
        $queue->setId( $this->getQueueDao()->add( $queue ) );
        return $queue;
    }

    // ... SCHEDULE


    /**
     * @return WebsiteScheduleModel
     */
    public function addWebsiteSchedule( WebsiteScheduleModel $website = null )
    {
        $website = $website ? $website : self::createWebsiteScheduleTest();
        $website->setId( $this->websiteScheduleDao->add( $website, null ) );
        return $website;
    }

    /**
     * @return WebsiteScheduleModel
     */
    public function addWesiteBuildingSchedule( $websiteId, $buildingId )
    {
        $this->websiteScheduleDao->addBuilding( $websiteId, $buildingId );
    }

    /**
     * @return RoomScheduleModel
     */
    public function addRoomSchedule( $websiteId, RoomScheduleModel $room = null )
    {
        $room = $room ? $room : self::createRoomScheduleTest();
        $room->setId( $this->roomScheduleDao->add( $room, $websiteId ) );
        return $room;
    }

    // ... /SCHEDULE


    // ... /ADD


    // /FUNCTIONS


}

?>