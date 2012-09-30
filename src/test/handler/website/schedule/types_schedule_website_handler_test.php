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
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();
        $this->websiteScheduleDao->removeAll();
        $this->roomScheduleDao->removeAll();
        $this->facultyScheduleDao->removeAll();
    }

    public static function getWebpage( $path )
    {
        return "http://" . $_SERVER[ "HTTP_HOST" ] . dirname( $_SERVER[ "REQUEST_URI" ] ) . "/" . $path;
    }

    private function generateWebsite( $urlPath, $type )
    {
        $website = WebsiteScheduleFactoryModel::createWebsiteSchedule( self::getWebpage( $urlPath ), $type );
        $website->setId( $this->websiteScheduleDao->add( $website, null ) );
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

    public function testRoomType( $website = null )
    {
        $this->typeScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( $this->roomScheduleDao );
        if ( !$website )
            $website = $this->generateRoomWebsite();

        $this->typeScheduleWebsiteHandler->handle( $website, new TestRoomTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_ROOM );

        $rooms = $this->roomScheduleDao->getAll();

        $this->assertEqual( self::$ROOMSEARCH_COUNT, $rooms->size() );
    }

    public function testRoomTypeDuplicate()
    {
        $website = $this->generateRoomWebsite();
        $this->testRoomType( $website );
        $this->testRoomType( $website );
    }

    public function _testFacultyType()
    {
        $this->typeScheduleWebsiteHandler = new TypesScheduleWebsiteHandler( $this->facultyScheduleDao );
        $website = $this->generateFacultyWebsite();

        $this->typeScheduleWebsiteHandler->handle( $website, new TestFacultyTypesScheduleUrlWebsiteHandler(),
                TypeScheduleModel::TYPE_FACULTY );

        $faculties = $this->facultyScheduleDao->getAll();

        $this->assertEqual( self::$FACULTYSEARCH_COUNT, $faculties->size() );
    }

    // /FUNCTIONS


}

?>