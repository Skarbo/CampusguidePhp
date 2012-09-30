<?php

class EntriesScheduleWebsiteHandler extends Handler
{

    // VARIABLES


    /**
     * @var WebsiteParser
     */
    private $websiteParser;
    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;
    /**
     * @var EntriesScheduleHandler
     */
    private $entriesHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( CampusguideHandler $campusguideHandler )
    {
        $this->setWebsiteParser( new WebsiteParser() );
        $this->setCampusguideHandler( $campusguideHandler );
        $this->setEntriesHandler( new EntriesScheduleHandler( $campusguideHandler ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return WebsiteParser
     */
    public function getWebsiteParser()
    {
        return $this->websiteParser;
    }

    /**
     * @param WebsiteParser $websiteParser
     */
    public function setWebsiteParser( WebsiteParser $websiteParser )
    {
        $this->websiteParser = $websiteParser;
    }

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
     * @return EntriesScheduleHandler
     */
    public function getEntriesHandler()
    {
        return $this->entriesHandler;
    }

    /**
     * @param EntriesScheduleHandler $entriesHandler
     */
    public function setEntriesHandler( EntriesScheduleHandler $entriesHandler )
    {
        $this->entriesHandler = $entriesHandler;
    }

    // ... /GETTERS/SETTERS


    public function handle( WebsiteScheduleModel $website, EntriesScheduleUrlWebsiteHandler $entriesUrlHandler, TypeScheduleListModel $types, $startWeek, $endWeek )
    {
        // Algorithm
        $algorithm = $this->getAlgorithm( $website->getType() );

        // Algorithm must be given
        if ( !$algorithm )
        {
            throw new HandlerException( sprintf( "Algorithm for type \"%s\" not given", $website->getType() ),
                    HandlerException::ALGORITHM_NOT_GIVEN );
        }

        // Parse website
        $entries = EntryScheduleListModel::get_(
                $this->getWebsiteParser()->parse(
                        $entriesUrlHandler->getEntriesUrl( $website->getUrl(), $types, $startWeek, $endWeek ),
                        $algorithm ) );

        // Handle Entries
        $this->getEntriesHandler()->handle( $website->getId(), $entries );
    }

    /**
     * @param string $type
     * @param string $websiteType
     * @return WebsiteAlgorithmParser
     */
    private function getAlgorithm( $websiteType )
    {
        switch ( $websiteType )
        {
            case WebsiteScheduleModel::TYPE_TIMEEDIT :
                return new EntriesTimeeditScheduleWebsiteAlgorithmParser();
                break;
        }
    }

    // /FUNCTION


}

?>