<?php

class TypesScheduleWebsiteHandler extends Handler
{

    // VARIABLES


    const MODE_ALLPAGES = "allpages";
    const MODE_FIRSTPAGE = "firstpage";

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


    public function handle( WebsiteScheduleModel $website, TypesScheduleUrlWebsiteHandler $typesUrlHandler, $type, $mode = TypesScheduleWebsiteHandler::MODE_ALLPAGES )
    {
        $algorithm = $this->getAlgorithm( $type, $website->getType() );

        // Algorithm must be given
        if ( !$algorithm )
        {
            throw new HandlerException( sprintf( "Algorithm for type \"%s\" not given", $website->getType() ),
                    HandlerException::ALGORITHM_NOT_GIVEN );
        }

        $page = 1;
        do
        {
            if ( $page == 4 )
                throw new Exception( "To many pages!" );
                // Parse website
            $result = TypesScheduleAlgorithmResultParser::get_(
                    $this->getWebsiteParser()->parse(
                            $typesUrlHandler->getTypesUrl( $website->getUrl(), $type, $page ), $algorithm ) );

            // Handle types
            if ( $result )
            {
                $this->getTypesScheduleHandler()->handle( $website->getId(), $result->getTypes() );
            }

            $page++;
        } while ( $mode == TypesScheduleWebsiteHandler::MODE_ALLPAGES && $result && $page <= $result->getPages() );
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
                return new TypesTimeeditScheduleWebsiteAlgorithmParser( $type );
                break;
        }
    }

    // /FUNCTION


}

?>