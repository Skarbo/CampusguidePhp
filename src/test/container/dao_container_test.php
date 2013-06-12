<?php

class DaoContainerTest extends DaoContainer
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function removeAll()
    {
        $this->getFacilityDao()->removeAll();
        $this->getBuildingDao()->removeAll();
        $this->getSectionBuildingDao()->removeAll();
        $this->getElementBuildingDao()->removeAll();
        $this->getFloorBuildingDao()->removeAll();
        $this->getNodeNavigationBuildingDao()->removeAll();

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

    // ... ... BUILDING


    /**
     * @return BuildingModel
     */
    public static function createBuildingTest( $facilityId )
    {
        $building = BuildingFactoryModel::createBuilding( "Test Building", $facilityId,
                array ( "streetname", "city", "postal", "country" ),
                array ( array ( "30.1", "40.1" ), array ( "50.1", "60.1" ), array ( "70.1", "80.1" ) ),
                array ( "10.1", "20.1" ) );
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
     * @return SectionBuildingModel
     */
    public static function createSectionBuildingTest( $buildingId )
    {
        $sectionBuilding = SectionBuildingFactoryModel::createSectionBuilding( $buildingId, "Section Test",
                array ( array ( array ( 100, 200 ), array ( 300, 400 ) ) ) );
        return $sectionBuilding;
    }

    /**
     * @return NodeNavigationBuildingModel
     */
    public function createNodeNavigationBuilding( $floorId, $coordinate = array(), $element = null, $edges = array() )
    {
        $coordinate = $coordinate ? $coordinate : array ( "x" => 100, "y" => 200 );
        $nodeNavigation = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floorId, $coordinate );
        return $nodeNavigation;
    }

    // ... ... /BUILDING


    public static function createQueueTest()
    {
        return QueueFactoryModel::createQueue( "test", QueueModel::PRIORITY_LOW );
    }

    // ... ... SCHEDULE


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

    // ... ... /SCHEDULE


    // ... /CREATE


    // ... ADD


    /**
     * @return FacilityModel
     */
    public function addFacility()
    {
        $facility = DaoContainerTest::createFacilityTest();
        $facility->setId( $this->facilityDao->add( $facility, null ) );
        return $facility;
    }

    // ... ... BUILDING


    /**
     * @return BuildingModel
     */
    public function addBuilding( $facilityId )
    {
        $building = DaoContainerTest::createBuildingTest( $facilityId );
        $building->setId( $this->buildingDao->add( $building, $facilityId ) );
        return $building;
    }

    /**
     * @return SectionBuildingModel
     */
    public function addSection( $buildingId )
    {
        $section = DaoContainerTest::createSectionBuildingTest( $buildingId );
        $section->setId( $this->sectionBuildingDao->add( $section, $buildingId ) );
        return $section;
    }

    /**
     * @return RoomBuildingModel
     */
    public function addElement( $floorId, ElementBuildingModel $element )
    {
        $element = $element ? $element : DaoContainerTest::createElementBuildingTest( $floorId );
        $element->setId( $this->elementBuildingDao->add( $element, $floorId ) );
        return $element;
    }

    /**
     * @return FloorBuildingModel
     */
    public function addFloor( $buildingId )
    {
        $floor = DaoContainerTest::createFloorBuildingTest( $buildingId );
        $floor->setId( $this->getFloorBuildingDao()->add( $floor, $buildingId ) );
        return $floor;
    }

    /**
     * @return NodeNavigationBuildingModel
     */
    public function addNodeNavigation( $floorId, NodeNavigationBuildingModel $node = null )
    {
        $node = $node ? $node : $this->createNodeNavigationBuilding( $floorId );
        $node->setId( $this->getNodeNavigationBuildingDao()->add( $node, $floorId ) );
        return $node;
    }

    // ... ... /BUILDING


    /**
     * @return FloorBuildingModel
     */
    public function addQueue( QueueModel $queue = null )
    {
        $queue = $queue ? $queue : DaoContainerTest::createQueueTest();
        $queue->setId( $this->getQueueDao()->add( $queue ) );
        return $queue;
    }

    // ... SCHEDULE


    /**
     * @return WebsiteScheduleModel
     */
    public function addWebsiteSchedule( WebsiteScheduleModel $website = null )
    {
        $website = $website ? $website : DaoContainerTest::createWebsiteScheduleTest();
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
        $room = $room ? $room : DaoContainerTest::createRoomScheduleTest();
        $room->setId( $this->roomScheduleDao->add( $room, $websiteId ) );
        return $room;
    }

    // ... /SCHEDULE


    // ... /ADD


    // /FUNCTIONS


}

?>