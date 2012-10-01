<?php

class RoomScheduleDaoTest extends CampusguideDaoTest
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
        $facility = $this->addFacility();
        $building = $this->addBuilding( $facility->getId() );
        $floor = $this->addFloor( $building->getId() );
        $element = $this->addElement( $floor->getId(), null, "", "test" );
        $element2 = $this->addElement( $floor->getId(), null, "", ElementBuildingModel::TYPE_GROUP_ROOM );

        $website = $this->addWebsiteSchedule();
        $this->addWesiteBuildingSchedule( $website->getId(), $building->getId() );
        $room = $this->addRoomSchedule( $website->getId(), $element2->getName() );
        $room2 = $this->addRoomSchedule( $website->getId(), "Test Room2" );

        $this->getCampusguideHandler()->getRoomScheduleDao()->mergeElements();

        $room = RoomScheduleModel::get_( $this->getCampusguideHandler()->getRoomScheduleDao()->get( $room->getId() ) );
        $this->assertEqual( $element2->getId(), $room->getElementId() );
        $room = RoomScheduleModel::get_( $this->getCampusguideHandler()->getRoomScheduleDao()->get( $room2->getId() ) );
        $this->assertEqual( $room2->getElementId(), 0 );
    }

    // /FUNCTION


}

?>