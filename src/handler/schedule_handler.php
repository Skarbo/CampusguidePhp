<?php

class ScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->setDaoContainer( $daoContainer );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return DaoContainer
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @param DaoContainer $daoContainer
     */
    public function setDaoContainer( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
    }

    // ... /GETTERS/SETTERS


    public function handleMerge()
    {



        $elements = $this->getDaoContainer()->getElementBuildingDao()->getAll();
        $buildings = $this->getDaoContainer()->getBuildingDao()->getForeign($elements->getForeignIds());

    }

    // /FUNCTION


}

?>