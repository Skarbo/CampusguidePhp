<?php

abstract class CampusguideDaoTest extends DbTest
{

    // VARIABLES


    /**
     * @var CampusguideHandler
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

    /**
     * @return CampusguideHandlerTest
     */
    protected function getCampusguideHandlerTest()
    {
        return $this->campusguideHandlerTest;
    }

    // /FUNCTIONS


}

?>