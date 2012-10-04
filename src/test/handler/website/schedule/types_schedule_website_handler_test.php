<?php

class TestRoomTypesScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        return $url;
    }

}

class TestGroupTypesScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        return $url;
    }

}

class TestFacultyTypesScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        return sprintf( $url, $page );
    }

}

class TypesScheduleWebsiteHandlerTest extends ScheduleWebsiteHandlerTest
{

    // VARIABLES


    public static $PATH_ROOMSEARCH = "example/timeedit/roomsearch.html";
    public static $PATH_GROUPSEARCH = "example/timeedit/groupsearch.html";
    public static $PATH_FACULTYSEARCH = "example/timeedit/facultysearch_%s.html";
    public static $PATH_GROUPSEARCHMANY = "example/timeedit/types/group_search_many.htm";

    public static $ROOMSEARCH_COUNT = 5;
    public static $GROUPSEARCH_COUNT = 6;
    public static $FACULTYSEARCH_COUNT = 30;

    /**
     * @var WebsiteScheduleDbDao
     */
    private $websiteScheduleDao;
    /**
     * @var RoomScheduleDao
     */
    private $roomScheduleDao;
    /**
     * @var FacultyScheduleDao
     */
    private $facultyScheduleDao;
    /**
     * @var GroupScheduleDao
     */
    private $groupScheduleDao;
    /**
     * @var TypesScheduleWebsiteHandler
     */
    private $typeScheduleWebsiteHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypesScheduleWebsiteHandler Test" );

        $this->websiteScheduleDao = new WebsiteScheduleDbDao( $this->getDbApi() );
        $this->roomScheduleDao = new RoomScheduleDbDao( $this->getDbApi() );
        $this->facultyScheduleDao = new FacultyScheduleDbDao( $this->getDbApi() );
        $this->groupScheduleDao = new GroupScheduleDbDao( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();
        $this->getCampusguideHandlerTest()->getwebsiteScheduleDao()->removeAll();
        $this->getCampusguideHandlerTest()->getroomScheduleDao()->removeAll();
        $this->getCampusguideHandlerTest()->getfacultyScheduleDao()->removeAll();
    }

    public static function getWebpage( $path )
    {
        return "http://" . $_SERVER[ "HTTP_HOST" ] . dirname( $_SERVER[ "REQUEST_URI" ] ) . "/" . $path;
    }

    private function generateWebsite( $urlPath, $type )
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule( self::getWebpage( $urlPath ), $type );
        $website->setId( $this->getCampusguideHandlerTest()->getwebsiteScheduleDao()->add( $website, null ) );
        return $website;
    }

    private function generateRoomWebsite()
    {
        return $this->generateWebsite( self::$PATH_ROOMSEARCH, WebsiteScheduleModel::TYPE_TIMEEDIT );
    }

    private function generateFacultyWebsite()
    {
        return $this->generateWebsite( self::$PATH_FACULTYSEARCH, WebsiteScheduleModel::TYPE_TIMEEDIT );
    }

    public function _testRoomType( $website = null )
    {
        $this->typeScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( $this->roomScheduleDao );
        if ( !$website )
            $website = $this->generateRoomWebsite();

        $result = $this->typeScheduleWebsiteHandler->handle( $website, new TestRoomTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_ROOM );

        $rooms = $this->getCampusguideHandlerTest()->getroomScheduleDao()->getAll();

        $this->assertEqual( self::$ROOMSEARCH_COUNT, $rooms->size() );
    }

    public function _testRoomTypeDuplicate()
    {
        $website = $this->generateRoomWebsite();
        $this->testRoomType( $website );
        $this->testRoomType( $website );
    }

    public function _testFacultyType()
    {
        $this->typeScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( $this->facultyScheduleDao );
        $website = $this->generateFacultyWebsite();

        $result = $this->typeScheduleWebsiteHandler->handle( $website, new TestFacultyTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_FACULTY, TypesScheduleWebsiteHandler::MODE_MULTIPLEPAGES );

        $faculties = $this->getCampusguideHandlerTest()->getfacultyScheduleDao()->getAll();

        $this->assertEqual( self::$FACULTYSEARCH_COUNT, $faculties->size() );
        $this->assertTrue( $result->isFinished() );
        $this->assertEqual( 3, $result->getPages() );
        $this->assertEqual( 3, $result->getPage() );
        $this->assertEqual( TypesScheduleResultWebsiteHandler::CODE_FINISHED, $result->getCode() );
    }

    public function testGroupTypeMany()
    {
        $this->typeScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( $this->groupScheduleDao );
        $website = $this->generateWebsite( self::$PATH_GROUPSEARCHMANY, WebsiteScheduleModel::TYPE_TIMEEDIT );

        $result = $this->typeScheduleWebsiteHandler->handle( $website, new TestGroupTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_GROUP, TypesScheduleWebsiteHandler::MODE_MULTIPLEPAGES );

        $this->assertFalse( $result->isFinished() );
        $this->assertEqual( 27, $result->getPages() );
        $this->assertEqual( 1, $result->getPage() );
        $this->assertEqual( TypesScheduleWebsiteHandler::$MAX_PAGES, $result->getCount() );
        $this->assertEqual( TypesScheduleResultWebsiteHandler::CODE_EXCEEDPAGES, $result->getCode() );
    }

    // /FUNCTIONS


}

?>