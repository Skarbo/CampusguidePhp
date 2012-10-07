<?php

abstract class ControllerTest extends WebTest
{

    // VARIABLES


    private static $PAGE_COMMAND = "command.php";
    private static $PAGE_API_REST = "api_rest.php";

    /**
     * @var DaoContainerTest
     */
    protected $daoContainerTest;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->daoContainerTest = new DaoContainerTest( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->getDaoContainerTest()->removeAll();
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
     * @return DaoContainerTest
     */
    public function getDaoContainerTest()
    {
        return $this->daoContainerTest;
    }

    // ... /GET


    // /FUNCTIONS


}

?>