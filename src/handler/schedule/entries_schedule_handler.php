<?php

class EntriesScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @return TypesScheduleHandler
     */
    private $typesScheduleHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->setDaoContainer( $daoContainer );
        $this->setTypesScheduleHandler( new TypesScheduleHandler( null ) );
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

            $entry->setId( $this->getDaoContainer()->getEntryScheduleDao()->add( $entry, $websiteId ) );

            foreach ( $entry->getOccurences() as $occurence )
            {
                $this->getDaoContainer()->getEntryScheduleDao()->addOccurence( $entry->getId(), $occurence );
            }

            // Group
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getDaoContainer()->getGroupScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getGroups(), $entry->getId() );

            // Program
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getDaoContainer()->getProgramScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getPrograms(), $entry->getId() );

            // Room
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getDaoContainer()->getRoomScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getRooms(), $entry->getId() );

            // Faculty
            $this->getTypesScheduleHandler()->setTypeScheduleDao(
                    $this->getDaoContainer()->getFacultyScheduleDao() );
            $this->getTypesScheduleHandler()->handle( $websiteId, $entry->getFaculties(), $entry->getId() );
        }

    }

    // /FUNCTIONS


}

?>