<?php

abstract class DbTest extends UnitTestCase
{

    // VARIABLES


//     protected static $DB_CONFIG_LOCALHOST_TEST = array ( "host" => "kris-server",
//             "db" => "campusguide_test", "user" => "kris-win", "pass" => "kris1234" );
    public static $DB_CONFIG_LOCALHOST_TEST = array ( "host" => "localhost",
            "db" => "campusguide_test", "user" => "root", "pass" => "" );

    private $db_api;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->db_api = new PdoDbApi( self::$DB_CONFIG_LOCALHOST_TEST[ "host" ],
                self::$DB_CONFIG_LOCALHOST_TEST[ "db" ],
                self::$DB_CONFIG_LOCALHOST_TEST[ "user" ],
                self::$DB_CONFIG_LOCALHOST_TEST[ "pass" ] );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return DbApi
     */
    protected function getDbApi()
    {
        return $this->db_api;
    }

    // ... /GET


    // ... BEFORE/AFTER


    public function setUp()
    {
        $this->getDbApi()->connect();
    }

    // ... /BEFORE/AFTER


// /FUNCTIONS


}

?>