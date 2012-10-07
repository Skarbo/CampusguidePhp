<?php

abstract class DaoTest extends DbTest
{

    // VARIABLES


    /**
     * @var DaoContainer
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

    /**
     * @return DaoContainerTest
     */
    protected function getDaoContainerTest()
    {
        return $this->daoContainerTest;
    }

    // /FUNCTIONS


}

?>