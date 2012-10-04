<?php

class EntriesScheduleWebsiteHandler extends Handler
{

    // VARIABLES


    private static $MAX_COUNT = 5;

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


    /**
     * @param WebsiteScheduleModel $website
     * @param EntriesScheduleUrlWebsiteHandler $entriesUrlHandler
     * @param TypeScheduleListModel $types
     * @param integer $startWeek
     * @param integer $endWeek
     * @throws HandlerException
     * @return EntriesScheduleResultWebsiteHandler
     */
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

        $count = 0;
        do
        {
            $loop = false;
            try
            {
                $typesSliced = $types->slice( $count );

                // Parse website
                $entries = EntryScheduleListModel::get_(
                        $this->getWebsiteParser()->parse(
                                $entriesUrlHandler->getEntriesUrl( $website->getUrl(), $typesSliced, $startWeek,
                                        $endWeek ), $algorithm ) );
            }
            catch ( ParserException $e )
            {
                switch ( $e->getCustomCode() )
                {
                    case EntriesTimeeditScheduleWebsiteAlgorithmParser::PARSER_EXCEPTION_TOOMANYWEEKS :
                        $loop = true;
                        $count++;
                        if ( $count >= self::$MAX_COUNT )
                            return new EntriesScheduleResultWebsiteHandler( $typesSliced->size(),
                                    EntriesScheduleResultWebsiteHandler::CODE_EXCEEDING );
                        break;

                    default :
                        throw $e;
                        break;
                }
            }
        } while ( $loop && $count <= self::$MAX_COUNT );

        // Handle Entries
        $this->getEntriesHandler()->handle( $website->getId(), $entries );

        return new EntriesScheduleResultWebsiteHandler( $types->size() - $count,
                EntriesScheduleResultWebsiteHandler::CODE_FINISHED );
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
            case WebsiteScheduleModel::TYPE_TIMEEDIT_TEST :
                return new EntriesTimeeditScheduleWebsiteAlgorithmParser();
                break;
        }
    }

    // /FUNCTION


}

?>