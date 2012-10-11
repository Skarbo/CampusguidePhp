<?php

class ScheduleQueueHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var TypesScheduleWebsiteHandler
     */
    private $typesScheduleWebsiteHandler;
    /**
     * @var EntriesScheduleWebsiteHandler
     */
    private $entriesScheduleWebsiteHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->setDaoContainer( $daoContainer );
        $this->setTypesScheduleWebsiteHandler( new TypesScheduleWebsiteHandler( null ) );
        $this->setEntriesScheduleWebsiteHandler( new EntriesScheduleWebsiteHandler( $this->getDaoContainer() ) );
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
     * @return TypesScheduleWebsiteHandler
     */
    public function getTypesScheduleWebsiteHandler()
    {
        return $this->typesScheduleWebsiteHandler;
    }

    /**
     * @param TypesScheduleWebsiteHandler $typesScheduleWebsiteHandler
     */
    public function setTypesScheduleWebsiteHandler( TypesScheduleWebsiteHandler $typesScheduleWebsiteHandler )
    {
        $this->typesScheduleWebsiteHandler = $typesScheduleWebsiteHandler;
    }

    /**
     * @return EntriesScheduleWebsiteHandler
     */
    public function getEntriesScheduleWebsiteHandler()
    {
        return $this->entriesScheduleWebsiteHandler;
    }

    /**
     * @param EntriesScheduleWebsiteHandler $entriesScheduleWebsiteHandler
     */
    public function setEntriesScheduleWebsiteHandler( EntriesScheduleWebsiteHandler $entriesScheduleWebsiteHandler )
    {
        $this->entriesScheduleWebsiteHandler = $entriesScheduleWebsiteHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @param integer $websiteId
     * @throws Exception
     * @return StandardModel
     */
    private function getWebsite( $websiteId )
    {
        $website = $this->getDaoContainer()->getWebsiteScheduleDao()->get( $websiteId );

        if ( !$website )
            throw new Exception( sprintf( "Website \"%s\" does not exist", $websiteId ) );

        return $website;
    }

    /**
     * @param string $websiteType
     * @throws Exception
     * @return TypesScheduleUrlWebsiteHandler
     */
    private function getTypesUrlHandler( $websiteType )
    {
        switch ( $websiteType )
        {
            case WebsiteScheduleModel::TYPE_TIMEEDIT :
                return new TypesTimeeditScheduleUrlWebsiteHandler();
                break;

            case WebsiteScheduleModel::TYPE_TIMEEDIT_TEST :
                return new TypesTimeeditScheduleUrlWebsiteHandlerTest();
                break;
        }

        throw new Exception( sprintf( "Types URL handler not given for website type\"%s\"", $websiteType ) );
    }

    /**
     * @param string $websiteType
     * @throws Exception
     * @return EntriesScheduleUrlWebsiteHandler
     */
    private function getEntriesUrlHandler( $websiteType )
    {
        switch ( $websiteType )
        {
            case WebsiteScheduleModel::TYPE_TIMEEDIT :
                return new EntriesTimeeditScheduleUrlWebsiteHandler();
                break;

            case WebsiteScheduleModel::TYPE_TIMEEDIT_TEST :
                return new EntriesTimeeditScheduleUrlWebsiteHandlerTest();
                break;
        }

        throw new Exception( sprintf( "Entries URL handler not given for website type\"%s\"", $websiteType ) );
    }

    /**
     * @param string $scheduleType
     * @throws Exception
     * @return string
     */
    private function getScheduleType( $scheduleType )
    {
        if ( !in_array( $scheduleType, TypeScheduleModel::$TYPES ) )
            throw new Exception( sprintf( "Unknown schedule type \"%s\" given in Queue argument", $scheduleType ) );

        return $scheduleType;
    }

    // ... /GET


    /**
     * @param QueueModel $queue
     */
    public function handle( QueueModel $queue )
    {
        if ( !$queue )
            return false;

        switch ( $queue->getType() )
        {
            case QueueModel::TYPE_SCHEDULE_TYPES :
                $this->handleTypes( $queue );
                break;

            case QueueModel::TYPE_SCHEDULE_ENTRIES :
                $this->handleEntries( $queue );
                break;

            default :
                return false;
                break;
        }
    }

    /**
     * @param QueueModel $queue
     */
    private function handleEntries( QueueModel $queue )
    {
        $website = $this->getWebsite( $queue->getWebsiteId() );
        $entriesUrlHandler = $this->getEntriesUrlHandler( $website->getType() );
        $scheduleType = $this->getScheduleType( $queue->getScheduleType() );

        $scheduleTypeIds = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_IDS, array () );
        $scheduleTypeCodesPr = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_CODES_PR, 0 );
        $scheduleTypeWeeks = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_WEEKS,
                array () );

        if ( empty( $scheduleTypeIds ) )
        {
            $this->getDaoContainer()->getQueueDao()->remove( $queue->getId() );
            return true;
        }

        $typeScheduelDao = null;
        switch ( $scheduleType )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                $typeScheduelDao = $this->getDaoContainer()->getFacultyScheduleDao();
                break;
            case TypeScheduleModel::TYPE_GROUP :
                $typeScheduelDao = $this->getDaoContainer()->getGroupScheduleDao();
                break;
            case TypeScheduleModel::TYPE_PROGRAM :
                $typeScheduelDao = $this->getDaoContainer()->getProgramScheduleDao();
                break;
            case TypeScheduleModel::TYPE_ROOM :
                $typeScheduelDao = $this->getDaoContainer()->getRoomScheduleDao();
                break;
        }
        $scheduleTypes = TypeScheduleListModel::get_( $typeScheduelDao->getList( $scheduleTypeIds ) );

        if ( $scheduleTypeCodesPr )
            $scheduleTypes = $scheduleTypes->limit( $scheduleTypeCodesPr );

        $weekStart = Core::parseTimestamp( Core::arrayAt( $scheduleTypeWeeks, 0, time() ) );
        $weekEnd = Core::parseTimestamp( Core::arrayAt( $scheduleTypeWeeks, 1, strtotime( "next week", time() ) ) );

        $result = $this->getEntriesScheduleWebsiteHandler()->handle( $website, $entriesUrlHandler, $scheduleTypes,
                $weekStart, $weekEnd );

        if ( $result->getCode() == EntriesScheduleResultWebsiteHandler::CODE_EXCEEDING )
        {
            $arguments = $queue->getArguments();
            $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_CODES_PR ] = $result->getCount();
            $queue->setArguments( $arguments );
        }
        elseif ( $result->getCode() == EntriesScheduleResultWebsiteHandler::CODE_FINISHED )
        {
            if ( $result->getCount() == $scheduleTypes->size() )
            {
                $this->getDaoContainer()->getQueueDao()->remove( $queue->getId() );
                return true;
            }
            else
            {
                $scheduleTypesSliced = $scheduleTypes->slice( $result->getCount() );
                $arguments = $queue->getArguments();
                $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_IDS ] = $scheduleTypesSliced->getIds();
                $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_CODES_PR ] = $result->getCount();
                $queue->setArguments( $arguments );
            }
        }
        $this->getDaoContainer()->getQueueDao()->edit( $queue->getId(), $queue );
        return true;
    }

    /**
     * @param QueueModel $queue
     */
    private function handleTypes( QueueModel $queue )
    {
        $website = $this->getWebsite( $queue->getWebsiteId() );
        $typesUrlHandler = $this->getTypesUrlHandler( $website->getType() );
        $scheduleType = $this->getScheduleType( $queue->getScheduleType() );

        $scheduleTypePage = Core::arrayAt( $queue->getArguments(), QueueModel::$ARGUMENT_SCHEDULE_TYPE_PAGE, 1 );

        if ( !in_array( $scheduleType, TypeScheduleModel::$TYPES ) )
            throw new Exception( sprintf( "Unknown schedule type \"%s\" given in Queue argument", $scheduleType ) );

        switch ( $scheduleType )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                $this->getTypesScheduleWebsiteHandler()->setTypeScheduleDao(
                        $this->getDaoContainer()->getFacultyScheduleDao() );
                break;
            case TypeScheduleModel::TYPE_GROUP :
                $this->getTypesScheduleWebsiteHandler()->setTypeScheduleDao(
                        $this->getDaoContainer()->getGroupScheduleDao() );
                break;
            case TypeScheduleModel::TYPE_PROGRAM :
                $this->getTypesScheduleWebsiteHandler()->setTypeScheduleDao(
                        $this->getDaoContainer()->getProgramScheduleDao() );
                break;
            case TypeScheduleModel::TYPE_ROOM :
                $this->getTypesScheduleWebsiteHandler()->setTypeScheduleDao(
                        $this->getDaoContainer()->getRoomScheduleDao() );
                break;
        }
        $return = $this->getTypesScheduleWebsiteHandler()->handle( $website, $typesUrlHandler, $scheduleType,
                TypesScheduleWebsiteHandler::MODE_MULTIPLEPAGES, $scheduleTypePage );

        if ( $return->isFinished() )
        {
            $this->getDaoContainer()->getQueueDao()->remove( $queue->getId() );
            return true;
        }
        elseif ( $return->getCode() == TypesScheduleResultWebsiteHandler::CODE_EXCEEDPAGES )
        {
            $scheduleTypePage = $return->getPage() + 1;
        }

        $arguments = $queue->getArguments();
        $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_PAGE ] = $scheduleTypePage;
        $queue->setArguments( $arguments );

        $this->getDaoContainer()->getQueueDao()->edit( $queue->getId(), $queue );
        return true;
    }

    // /FUNCTIONS


}

?>