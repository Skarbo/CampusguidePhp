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
        $facility = $this->getCampusguideHandlerTest()->addFacility();
        $building = $this->getCampusguideHandlerTest()->addBuilding( $facility->getId() );
        $floor = $this->getCampusguideHandlerTest()->addFloor( $building->getId() );
        $element = $this->getCampusguideHandlerTest()->addElement( $floor->getId(), null, "", "test" );
        $element2 = $this->getCampusguideHandlerTest()->addElement( $floor->getId(), null, "", ElementBuildingModel::TYPE_GROUP_ROOM );

        $website = $this->getCampusguideHandlerTest()->addWebsiteSchedule();
        $this->getCampusguideHandlerTest()->addWesiteBuildingSchedule( $website->getId(), $building->getId() );
        $room = $this->getCampusguideHandlerTest()->addRoomSchedule( $website->getId(), $element2->getName() );
        $room2 = $this->getCampusguideHandlerTest()->addRoomSchedule( $website->getId(), "Test Room2" );

        $this->getCampusguideHandlerTest()->getRoomScheduleDao()->mergeElements();

        $room = RoomScheduleModel::get_( $this->getCampusguideHandlerTest()->getRoomScheduleDao()->get( $room->getId() ) );
        $this->assertEqual( $element2->getId(), $room->getElementId() );
        $room = RoomScheduleModel::get_( $this->getCampusguideHandlerTest()->getRoomScheduleDao()->get( $room2->getId() ) );
        $this->assertEqual( $room2->getElementId(), 0 );
    }

    // /FUNCTION


}

?>