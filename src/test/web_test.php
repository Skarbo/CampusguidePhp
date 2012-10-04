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

    public static function getWebsite( $page )
    {
        return sprintf( "http://%s%s/%s", $_SERVER[ "HTTP_HOST" ], dirname( $_SERVER[ "REQUEST_URI" ] ), $page );
    }

    public static function getWebsiteApi( $page, $arguments )
    {
        return sprintf( self::getWebsite( sprintf( "%s?/%s&mode=3", $page, $arguments ) ) );
    }

    // ... /GET


    // /FUNCTIONS


}

?>