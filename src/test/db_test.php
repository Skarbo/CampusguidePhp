<?php

abstract class DbTest extends AbstractDbTest
{

    // VARIABLES


    public static $DB_CONFIG_LOCALHOST_TEST = array ( "host" => "localhost", "db" => "campusguide_test",
            "user" => "root", "pass" => "" );

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    public function getDatabaseConfig()
    {
        return self::$DB_CONFIG_LOCALHOST_TEST;
    }

    // ... /GET


    // /FUNCTIONS


}

?>