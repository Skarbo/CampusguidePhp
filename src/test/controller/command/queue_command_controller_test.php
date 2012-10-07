<?php

class TestRoomTypesScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        return sprintf( $url, QueueCommandControllerTest::$PATH_TIMEEDIT_TYPES_ROOMSEARCH );
    }

}

class QueueCommandControllerTest extends ControllerTest
{

    // VARIABLES


    private static $PATH_TIMEEDIT_TYPES_PROGRAMSEARCH = "example/timeedit/types/program_search_%s.htm";
    public static $PATH_TIMEEDIT_TYPES_ROOMSEARCH = "example/timeedit/search/room_search.htm";

    private static $PROGRAMS_NAME = array ( "Fysikk videregående", "Matte videregående", "2MX/3MX", "AA", "AAAA", "ABC",
            "ADFERDSVANSKER", "Cellebiologi, molekylærbiologi og genetikk", "Anatomi, fysiologi og histologi",
            "Etikk og kommunikasjon I", "Matematikk og statistikk", "Medisinsk lab. teknologi", "Org. kjemi og biokjemi" );
    private static $PROGRAMS_NAME_SHORT = array ( "2FY", "2MX-3MX", "2MX3MX", "AA", "AAAA", "ABC", "ADFVANS", "BIO001",
            "BIO002", "BIO003", "BIO004", "BIO005", "BIO006" );
    private static $PROGRAM_PAGE = 4;
    private static $ENTIRES = 14;
    private static $ROOMS = 5;

    /**
     * @var TypesScheduleWebsiteHandler
     */
    private $typesScheduleWebsiteHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "QueueCommandController Test" );

        $this->typesScheduleWebsiteHandler = new TypesScheduleWebsiteHandler();

        self::$PROGRAMS_NAME = Core::utf8Decode( self::$PROGRAMS_NAME );
        self::$PROGRAMS_NAME_SHORT = Core::utf8Decode( self::$PROGRAMS_NAME_SHORT );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function _testQueueCommandShouldParseTypeProgram()
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule(
                self::getWebsite( self::$PATH_TIMEEDIT_TYPES_PROGRAMSEARCH ), WebsiteScheduleModel::TYPE_TIMEEDIT_TEST );
        $website = $this->getDaoContainerTest()->addWebsiteSchedule( $website );

        $queue = QueueFactoryModel::createScheduleTypesQueue( $website->getId(), TypeScheduleModel::TYPE_PROGRAM, 1 );
        $queue = $this->getDaoContainerTest()->addQueue( $queue );

        $url = self::getCommandWebsite( QueueCommandController::$CONTROLLER_NAME );
        $data = $this->get( $url );

        $this->showHeaders();
        $this->showRequest();
        $this->showSource();

        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {
            $programs = ProgramScheduleListModel::get_(
                    $this->getDaoContainerTest()->getProgramScheduleDao()->getAll() );

            if ( $this->assertEqual( count( self::$PROGRAMS_NAME ), $programs->size() ) )
            {
                for ( $programs->rewind(), $i = 0; $programs->valid(); $programs->next(), $i++ )
                {
                    $program = $programs->current();

                    $this->assertEqual( self::$PROGRAMS_NAME[ $i ], $program->getName() );
                    $this->assertEqual( self::$PROGRAMS_NAME_SHORT[ $i ], $program->getNameShort() );
                }
            }

        }

        $queue = $this->getDaoContainerTest()->getQueueDao()->get( $queue->getId() );
        $programPage = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_PAGE );

        $this->assertEqual( self::$PROGRAM_PAGE, $programPage );

    }

    public function testQueueCommandShouldParseEntriesRooms()
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule( self::getWebsite( "%s" ),
                WebsiteScheduleModel::TYPE_TIMEEDIT_TEST );
        $website = $this->getDaoContainerTest()->addWebsiteSchedule( $website );

        $this->typesScheduleWebsiteHandler->setTypeScheduleDao(
                $this->getDaoContainerTest()->getRoomScheduleDao() );
        $this->typesScheduleWebsiteHandler->handle( $website, new TestRoomTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_ROOM );

        $roomFirst = $this->getDaoContainerTest()->addRoomSchedule( $website->getId() );
        $roomSecond = $this->getDaoContainerTest()->addRoomSchedule( $website->getId() );

        $rooms = RoomScheduleListModel::get_( $this->getDaoContainerTest()->getRoomScheduleDao()->getAll() );

        $this->assertEqual( self::$ROOMS, $rooms->size() );

        $queue = QueueFactoryModel::createScheduleEntriesQueue( $website->getId(), TypeScheduleModel::TYPE_ROOM,
                $rooms->getIds(), array ( time(), strtotime( "next week" ) ) );
        $queue = $this->getDaoContainerTest()->addQueue( $queue );

        $url = self::getCommandWebsite( QueueCommandController::$CONTROLLER_NAME );
        $data = $this->get( $url );

        $this->showHeaders();
        $this->showRequest();
        $this->showSource();

        if ( $this->assertResponse( AbstractController::STATUS_CREATED ) )
        {
            $entries = $this->getDaoContainerTest()->getEntryScheduleDao()->getAll();
            $this->assertEqual( self::$ENTIRES, $entries->size() );

            $queue = $this->getDaoContainerTest()->getQueueDao()->get( $queue->getId() );
            $scheduleTypeIds = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_IDS );
            $scheduleTypeCodesPr = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_CODES_PR );

            $this->assertEqual( 2, count( $scheduleTypeIds ) );
            $this->assertEqual( $scheduleTypeIds, array ( $roomFirst->getId(), $roomSecond->getId() ) );
            $this->assertEqual( self::$ROOMS - 2, $scheduleTypeCodesPr );
        }
    }

    // /FUNCTIONS


}

?>