<?php

class TestEntriesScheduleUrlWebsiteHandler implements EntriesScheduleUrlWebsiteHandler
{

    /**
     * @see EntriesScheduleUrlWebsiteHandler::getEntriesUrl()
     */
    public function getEntriesUrl( $url, TypeScheduleListModel $types, $weekStart, $weekStop )
    {
        return $url;
    }

}

class Test2EntriesScheduleUrlWebsiteHandler implements EntriesScheduleUrlWebsiteHandler
{

    /**
     * @see EntriesScheduleUrlWebsiteHandler::getEntriesUrl()
     */
    public function getEntriesUrl( $url, TypeScheduleListModel $types, $weekStart, $weekStop )
    {
        return sprintf( $url, EntriesScheduleWebsiteHandlerTest::$PATH_ENTRIES_ROOM );
    }

}

class TestTypesScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    public static $PATH_ENTRIES_SEARCH_FACULTY = "example/timeedit/search/faculty_search.htm";
    public static $PATH_ENTRIES_SEARCH_ROOM = "example/timeedit/search/room_search.htm";
    public static $PATH_ENTRIES_SEARCH_PROJECT = "example/timeedit/search/project_search.htm";
    public static $PATH_ENTRIES_SEARCH_GROUP = "example/timeedit/search/group_search.htm";

    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        $typeUrl = "";
        switch ( $type )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                $typeUrl = self::$PATH_ENTRIES_SEARCH_FACULTY;
                break;
            case TypeScheduleModel::TYPE_ROOM :
                $typeUrl = self::$PATH_ENTRIES_SEARCH_ROOM;
                break;
            case TypeScheduleModel::TYPE_PROGRAM :
                $typeUrl = self::$PATH_ENTRIES_SEARCH_PROJECT;
                break;
            case TypeScheduleModel::TYPE_GROUP :
                $typeUrl = self::$PATH_ENTRIES_SEARCH_GROUP;
                break;
        }
        return sprintf( $url, $typeUrl );
    }

}

class EntriesScheduleWebsiteHandlerTest extends ScheduleWebsiteHandlerTest
{

    // VARIABLES


    public static $PATH_ENTRIES_ROOM = "example/timeedit/entries_room.htm";
    public static $PATH_ENTRIES_6FLOOR = "example/timeedit/entries_6floor.htm";

    public static $ENTRIES_ROOM_ENTRIES = 14;
    public static $ENTRIES_ROOM_ENTRIES_OCCURENCES = array ( 2, 2, 2, 2, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2 );

    /**
     * @var EntriesScheduleWebsiteHandler
     */
    private $entriesScheduleWebsiteHandler;
    /**
     * @var TypesScheduleWebsiteHandler
     */
    private $typesScheduleWebsiteHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypesScheduleWebsiteHandler Test" );
        $this->entriesScheduleWebsiteHandler = new EntriesScheduleWebsiteHandler( $this->getCampsuguideHandler() );
        $this->typesScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( null );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();
        $this->getCampsuguideHandler()->getWebsiteScheduleDao()->removeAll();
        $this->getCampsuguideHandler()->getEntryScheduleDao()->removeAll();
        $this->getCampsuguideHandler()->getRoomScheduleDao()->removeAll();
        $this->getCampsuguideHandler()->getFacultyScheduleDao()->removeAll();
        $this->getCampsuguideHandler()->getGroupScheduleDao()->removeAll();
        $this->getCampsuguideHandler()->getProgramScheduleDao()->removeAll();
    }

    public static function getWebpage( $path )
    {
        return "http://" . $_SERVER[ "HTTP_HOST" ] . dirname( $_SERVER[ "REQUEST_URI" ] ) . "/" . $path;
    }

    private function generateWebsite( $urlPath, $type )
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule( self::getWebpage( $urlPath ), $type );
        $website->setId( $this->getCampsuguideHandler()->getWebsiteScheduleDao()->add( $website, null ) );
        return $website;
    }

    private function generateEntryRoomWebsite()
    {
        return $this->generateWebsite( self::$PATH_ENTRIES_ROOM, WebsiteScheduleModel::TYPE_TIMEEDIT );
    }

    private function generateEntry6FloorWebsite()
    {
        return $this->generateWebsite( self::$PATH_ENTRIES_6FLOOR, WebsiteScheduleModel::TYPE_TIMEEDIT );
    }

    public function _testTest()
    {
        $room1 = RoomScheduleFactoryModel::createRoomSchedule( null, null, "Room Name" );
        $room2 = RoomScheduleFactoryModel::createRoomSchedule( null, null, "Room Name" );
        $this->assertTrue( $room1->isEqual( $room2 ) );

        $room2->setNameShort( "Room Short" );
        $this->assertTrue( $room1->isEqual( $room2 ) );

        $room1->setCode( 1234 );
        $this->assertTrue( $room1->isEqual( $room2 ) );

        $room2->setCode( 4321 );
        $this->assertFalse( $room1->isEqual( $room2 ) );
    }

    public function _testEntries()
    {
        $website = $this->generateEntryRoomWebsite();

        $this->entriesScheduleWebsiteHandler->handle( $website, new TestEntriesScheduleUrlWebsiteHandler(),
                new RoomScheduleListModel(), null, null );

        $entries = EntryScheduleListModel::get_( $this->getCampsuguideHandler()->getEntryScheduleDao()->getAll() );

        $this->assertEqual( self::$ENTRIES_ROOM_ENTRIES, $entries->size() );
        for ( $entries->rewind(), $i = 0; $entries->valid(); $entries->next(), $i++ )
        {
            $entry = $entries->current();
            $this->assertEqual( self::$ENTRIES_ROOM_ENTRIES_OCCURENCES[ $i ], count( $entry->getOccurences() ),
                    "%s- index ${i} - entry id " . $entry->getId() );
        }

    }

    public function _testEntries6Floor()
    {
        $website = $this->generateEntry6FloorWebsite();

        $this->entriesScheduleWebsiteHandler->handle( $website, new TestEntriesScheduleUrlWebsiteHandler(),
                new RoomScheduleListModel(), null, null );

        //$entries = EntryScheduleListModel::get_( $this->getCampsuguideHandler()->getEntryScheduleDao()->getAll() );


        //         $this->assertEqual( self::$ENTRIES_ROOM_ENTRIES, $entries->size() );
        //         for ( $entries->rewind(), $i = 0; $entries->valid(); $entries->next(), $i++ )
        //         {
        //             $entry = $entries->current();
        //             $this->assertEqual( self::$ENTRIES_ROOM_ENTRIES_OCCURENCES[$i], count( $entry->getOccurences() ), "%s- index ${i} - entry id " . $entry->getId() );
        //         }


    }

    public function testEntriesSearch()
    {
        $website = $this->generateWebsite( "%s", WebsiteScheduleModel::TYPE_TIMEEDIT );

        // Rooms
        $this->typesScheduleWebsiteHandler->setTypeScheduleDao(
                $this->getCampsuguideHandler()->getRoomScheduleDao() );
        $this->typesScheduleWebsiteHandler->handle( $website, new TestTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_ROOM, TypesScheduleWebsiteHandler::MODE_FIRSTPAGE );

        // Faculties
        $this->typesScheduleWebsiteHandler->setTypeScheduleDao(
                $this->getCampsuguideHandler()->getFacultyScheduleDao() );
        $this->typesScheduleWebsiteHandler->handle( $website, new TestTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_FACULTY, TypesScheduleWebsiteHandler::MODE_FIRSTPAGE );

        // Groups
        $this->typesScheduleWebsiteHandler->setTypeScheduleDao(
                $this->getCampsuguideHandler()->getGroupScheduleDao() );
        $this->typesScheduleWebsiteHandler->handle( $website, new TestTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_GROUP, TypesScheduleWebsiteHandler::MODE_FIRSTPAGE );

        // Program
        $this->typesScheduleWebsiteHandler->setTypeScheduleDao(
                $this->getCampsuguideHandler()->getProgramScheduleDao() );
        $this->typesScheduleWebsiteHandler->handle( $website, new TestTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_PROGRAM, TypesScheduleWebsiteHandler::MODE_FIRSTPAGE );

        $rooms = $this->getCampsuguideHandler()->getRoomScheduleDao()->getAll();
        $facilities = $this->getCampsuguideHandler()->getFacultyScheduleDao()->getAll();
        $groups = $this->getCampsuguideHandler()->getGroupTypeElementBuildingDao()->getAll();
        $program = $this->getCampsuguideHandler()->getProgramScheduleDao()->getAll();

        $this->entriesScheduleWebsiteHandler->handle( $website, new Test2EntriesScheduleUrlWebsiteHandler(),
                new RoomScheduleListModel(), null, null );

        $roomsNew = $this->getCampsuguideHandler()->getRoomScheduleDao()->getAll();
        $facilitiesNew = $this->getCampsuguideHandler()->getFacultyScheduleDao()->getAll();
        $groupsNew = $this->getCampsuguideHandler()->getGroupTypeElementBuildingDao()->getAll();
        $programNew = $this->getCampsuguideHandler()->getProgramScheduleDao()->getAll();

        $this->assertEqual($rooms->size(), $roomsNew->size());
        $this->assertEqual($facilities->size(), $facilitiesNew->size());
        $this->assertEqual($groups->size(), $groupsNew->size());
        $this->assertEqual($program->size(), $programNew->size());

    }

    // /FUNCTIONS


}

?>