<?php

class EntriesScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;
    /**
     * @return TypesScheduleHandler
     */
    private $typesScheduleHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( CampusguideHandler $campusguideHandler )
    {
        $this->setCampusguideHandler( $campusguideHandler );
        $this->setTypesScheduleHandler( new TypesScheduleHandler( null ) );
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

    /**
     * @return TypesScheduleHandler
     */
    public function getTypesScheduleHandler()
    {
        return $this->typesScheduleHandler;
    }

    /**
     * @param TypesScheduleHandler $typesScheduleHandler
     */
    public function setTypesScheduleHandler( TypesScheduleHandler $typesScheduleHandler )
    {
        $this->typesScheduleHandler = $typesScheduleHandler;
    }

    // ... /GETTERS/SETTERS


    public function handle( $websiteId, EntryScheduleListModel $entries )
    {
        for ( $entries->rewind(); $entries->valid(); $entries->next() )
        {
            $entry = $entries->current();

            $entry->setId( $this->getCampusguideHandler()->getEntryScheduleDao()->add( $entry, $websiteId ) );

            foreach ( $entry->getOccurences() as $occurence )
            {
                $this->getCampusguideHandler()->getEntryScheduleDao()->addOccurence( $entry->getId(), $occurence );
            }

            // Group
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getCampusguideHandler()->getGroupScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getGroups(), $entry->getId() );

            // Program
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getCampusguideHandler()->getProgramScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getPrograms(), $entry->getId() );

            // Room
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getCampusguideHandler()->getRoomScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getRooms(), $entry->getId() );

            // Faculty
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getCampusguideHandler()->getFacultyScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getFaculties(), $entry->getId() );
        }

    }

    // /FUNCTIONS


}

?>