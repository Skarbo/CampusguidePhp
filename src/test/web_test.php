<?php

abstract class WebTest extends WebTestCase
{

    // VARIABLES


    private $db_api;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->db_api = new PdoDbApi( DbTest::$DB_CONFIG_LOCALHOST_TEST[ "host" ],
                DbTest::$DB_CONFIG_LOCALHOST_TEST[ "db" ], DbTest::$DB_CONFIG_LOCALHOST_TEST[ "user" ],
                DbTest::$DB_CONFIG_LOCALHOST_TEST[ "pass" ] );

        $this->getDbApi()->connect();
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


    // /FUNCTIONS


}

?>