<?php

abstract class CampusguideControllerTest extends WebTest
{

    // VARIABLES


    private static $PAGE_COMMAND = "command.php";
    private static $PAGE_API_REST = "api_rest.php";

    /**
     * @var CampusguideHandlerTest
     */
    protected $campusguideHandlerTest;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->campusguideHandlerTest = new CampusguideHandlerTest( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->getCampusguideHandlerTest()->removeAll();
    }

    // ... GET


    public static function getCommandWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_COMMAND, $arguments );
    }

    public static function getRestWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_API_REST, $arguments );
    }

    /**
     * @return CampusguideHandlerTest
     */
    public function getCampusguideHandlerTest()
    {
        return $this->campusguideHandlerTest;
    }

    // ... /GET


    // /FUNCTIONS


}

?>