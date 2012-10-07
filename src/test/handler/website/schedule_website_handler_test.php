<?php

class ScheduleWebsiteHandlerTest extends DbTest
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $campsuguideHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "ScheduleWebsiteParser test" );
        $this->campsuguideHandler = new DaoContainer( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return DaoContainer
     */
    protected function getCampsuguideHandler()
    {
        return $this->campsuguideHandler;
    }

    // /FUNCTIONS


}
?>