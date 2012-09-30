<?php

class WebsiteParserTest extends UnitTestCase
{

    // VARIABLES


    /**
     * @var WebsiteParser
     */
    public $websiteParser;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $name )
    {
        parent::__construct( $name );
        $this->websiteParser = new WebsiteParser();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getWebpage( $path )
    {
        return "http://" . $_SERVER[ "HTTP_HOST" ] . dirname( $_SERVER[ "REQUEST_URI" ] ) . "/" . $path;
    }

    // /FUNCTIONS


}

?>