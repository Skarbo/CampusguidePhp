<?php

class TypesScheduleWebsiteHandler extends Handler
{

    // VARIABLES


    const MODE_ONEPAGE = "onepage";
    const MODE_MULTIPLEPAGES = "multieplpages";

    public static $MAX_PAGES = 3;

    /**
     * @var WebsiteParser
     */
    private $websiteParser;
    /**
     * @var TypesScheduleHandler
     */
    private $typesHandler;
    /**
     * @var TypeScheduleDao
     */
    private $typeDao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( TypeScheduleDao $typeScheduleDao = null )
    {
        $this->setWebsiteParser( new WebsiteParser() );
        $this->setTypesScheduleHandler( new TypesScheduleHandler( $typeScheduleDao ) );
        if ( $typeScheduleDao )
            $this->setTypeScheduleDao( $typeScheduleDao );
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
     * @return TypesScheduleHandler
     */
    public function getTypesScheduleHandler()
    {
        return $this->typesHandler;
    }

    /**
     * @param TypesScheduleHandler $typeHandler
     */
    public function setTypesScheduleHandler( TypesScheduleHandler $typeHandler )
    {
        $this->typesHandler = $typeHandler;
    }

    /**
     * @return TypeScheduleDao
     */
    public function getTypeScheduleDao()
    {
        return $this->typeDao;
    }

    /**
     * @param TypeScheduleDao $typeDao
     */
    public function setTypeScheduleDao( TypeScheduleDao $typeDao )
    {
        $this->typeDao = $typeDao;
        $this->getTypesScheduleHandler()->setTypeScheduleDao( $typeDao );
    }

    // ... /GETTERS/SETTERS


    /**
     * @return TypesScheduleResultWebsiteHandler
     */
    public function handle( WebsiteScheduleModel $website, TypesScheduleUrlWebsiteHandler $typesUrlHandler, $type, $mode = TypesScheduleWebsiteHandler::MODE_ONEPAGE, $pageStart = 1 )
    {
        $algorithm = $this->getAlgorithm( $type, $website->getType() );

        // Algorithm must be given
        if ( !$algorithm )
        {
            throw new HandlerException( sprintf( "Algorithm for type \"%s\" not given", $website->getType() ),
                    HandlerException::ALGORITHM_NOT_GIVEN );
        }

        $page = $pageStart;
        $pageCount = 0;
        $result = null;
        $pages = array ();
        $counts = 0;
        do
        {
            // Parse website
            $result = TypesScheduleAlgorithmResultParser::get_(
                    $this->getWebsiteParser()->parse(
                            $typesUrlHandler->getTypesUrl( $website->getUrl(), $type, $page ), $algorithm ) );
            $pages[] = $page;
            $page++;
            $pageCount++;

            // Handle types
            if ( $result )
            {
                $counts += $result->getTypes()->size();
                $this->getTypesScheduleHandler()->handle( $website->getId(), $result->getTypes() );
            }

            // Exceed max pages at one parsing
            if ( $pageCount >= self::$MAX_PAGES )
            {
                LogHandler::doLog(
                        LogFactoryModel::createScheduleTypeLog( $website->getId(), $type,
                                sprintf( "Parsed %d %s's on page(s) %s of %d", $counts, $type, implode( ", ", $pages ),
                                        $result->getPages() ) ) );
                return new TypesScheduleResultWebsiteHandler( $result->getPage(), $result->getPages(), false,
                        TypesScheduleResultWebsiteHandler::CODE_EXCEEDPAGES, $pageCount );
            }

            //                 // Empty types
            //             if ( $result->getTypes() && $result->getTypes()->isEmpty() )
            //                 return new TypesScheduleResultWebsiteHandler( $result->getPage(), $result->getPages(), true,
            //                         TypesScheduleResultWebsiteHandler::CODE_EMPTYTYPES, $pageCount );
        } while ( $mode == TypesScheduleWebsiteHandler::MODE_MULTIPLEPAGES && $pageCount < self::$MAX_PAGES && $result && $page <= $result->getPages() );

        LogHandler::doLog(
                LogFactoryModel::createScheduleTypeLog( $website->getId(), $type,
                        sprintf( "Parsed %d %s's on page(s) %s of %d", $counts, $type, implode( ", ", $pages ),
                                $result->getPages() ) ) );

        return new TypesScheduleResultWebsiteHandler( $result->getPage(), $result->getPages(), true );
    }

    /**
     * @param string $type
     * @param string $websiteType
     * @return WebsiteAlgorithmParser
     */
    private function getAlgorithm( $type, $websiteType )
    {
        switch ( $websiteType )
        {
            case WebsiteScheduleModel::TYPE_TIMEEDIT :
            case WebsiteScheduleModel::TYPE_TIMEEDIT_TEST :
                return new TypesTimeeditScheduleWebsiteAlgorithmParser( $type );
                break;
        }
    }

    // /FUNCTION


}

?>