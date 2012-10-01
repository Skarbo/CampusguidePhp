<?php

class ScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( CampusguideHandler $campusguideHandler )
    {
        $this->setCampusguideHandler( $campusguideHandler );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return CampusguideHandler
     */
    public function getCampusguideHandler()
    {
        return $this->campusguideHandler;
    }

    /**
     * @param CampusguideHandler $campusguideHandler
     */
    public function setCampusguideHandler( CampusguideHandler $campusguideHandler )
    {
        $this->campusguideHandler = $campusguideHandler;
    }

    // ... /GETTERS/SETTERS


    public function handleMerge()
    {



        $elements = $this->getCampusguideHandler()->getElementBuildingDao()->getAll();
        $buildings = $this->getCampusguideHandler()->getBuildingDao()->getForeign($elements->getForeignIds());

    }

    // /FUNCTION


}

?>