<?php

class RoomScheduleDaoTest extends DaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "RoomScheduleDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testRoomElementMerge()
    {
        $facility = $this->getDaoContainerTest()->addFacility();
        $building = $this->getDaoContainerTest()->addBuilding( $facility->getId() );
        $floor = $this->getDaoContainerTest()->addFloor( $building->getId() );
        $element = $this->getDaoContainerTest()->addElement( $floor->getId(), null, "", "test" );
        $element2 = $this->getDaoContainerTest()->addElement( $floor->getId(), null, "", ElementBuildingModel::TYPE_GROUP_ROOM );

        $website = $this->getDaoContainerTest()->addWebsiteSchedule();
        $this->getDaoContainerTest()->addWesiteBuildingSchedule( $website->getId(), $building->getId() );
        $room = $this->getDaoContainerTest()->addRoomSchedule( $website->getId(), $element2->getName() );
        $room2 = $this->getDaoContainerTest()->addRoomSchedule( $website->getId(), "Test Room2" );

        $this->getDaoContainerTest()->getRoomScheduleDao()->mergeElements();

        $room = RoomScheduleModel::get_( $this->getDaoContainerTest()->getRoomScheduleDao()->get( $room->getId() ) );
        $this->assertEqual( $element2->getId(), $room->getElementId() );
        $room = RoomScheduleModel::get_( $this->getDaoContainerTest()->getRoomScheduleDao()->get( $room2->getId() ) );
        $this->assertEqual( $room2->getElementId(), 0 );
    }

    // /FUNCTION


}

?>