<?php

class QueueCampusguideCommandController extends CampusguideCommandController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "queue";

    private static $QUEUE_TYPES = array ( QueueModel::TYPE_SCHEDULE_TYPES, QueueModel::TYPE_SCHEDULE_ENTRIES );

    /**
     * @var ScheduleQueueHandler
     */
    private $scheduleQueueHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->setScheduleQueueHandler( new ScheduleQueueHandler( $this->getCampusguideHandler() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return ScheduleQueueHandler
     */
    private function getScheduleQueueHandler()
    {
        return $this->scheduleQueueHandler;
    }

    /**
     * @param ScheduleQueueHandler $scheduleQueueHandler
     */
    private function setScheduleQueueHandler( ScheduleQueueHandler $scheduleQueueHandler )
    {
        $this->scheduleQueueHandler = $scheduleQueueHandler;
    }

    // ... /GET


    /**
     * @see Controller::request()
     */
    public function request()
    {

        // Get next Queue
        $queue = $this->getCampusguideHandler()->getQueueDao()->getNext( self::$QUEUE_TYPES );

        // No next in queue
        if ( !$queue )
        {
            $this->setStatusCode( self::STATUS_NO_CONTENT );
            return;
        }

        // Handle Queue
        try
        {
            $this->handleQueue( $queue );
            $this->setStatusCode( self::STATUS_CREATED );
        }
        catch ( Exception $e )
        {
            $this->getCampusguideHandler()->getQueueDao()->increaseError( $queue->getId() );
            switch ( get_class( $e ) )
            {
                case ParserException::class_() :
                    DebugHandler::doDebug( DebugHandler::LEVEL_HIGH,
                            new DebugException( "QueueCampusguideCommandController error", $queue, $e->getMessage() ) );
                    break;

                default :
            }
            throw $e;
        }

    }

    private function handleQueue( QueueModel $queue )
    {
        switch ( $queue->getType() )
        {
            case QueueModel::TYPE_SCHEDULE_TYPES :
            case QueueModel::TYPE_SCHEDULE_ENTRIES :
                $this->getScheduleQueueHandler()->handle( $queue );
                break;
        }
    }

    // /FUNCTIONS


}

?>