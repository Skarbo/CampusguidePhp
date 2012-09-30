<?php

class ScheduleWebsiteHandlerTest extends DbTest
{

    // VARIABLES


    /**
     * @var CampusguideHandler
     */
    private $campsuguideHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "ScheduleWebsiteParser test" );
        $this->campsuguideHandler = new CampusguideHandler( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CampusguideHandler
     */
    protected function getCampsuguideHandler()
    {
        return $this->campsuguideHandler;
    }

    // /FUNCTIONS


}
?>