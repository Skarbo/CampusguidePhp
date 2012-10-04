<?php

class QueueHandler extends Handler
{

    // VARIABLES


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;
    /**
     * @var QueueValidator
     */
    private $queueValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( CampusguideHandler $campusguideHandler, QueueValidator $queueValidator )
    {
        $this->setCampusguideHandler( $campusguideHandler );
        $this->setQueueValidator( $queueValidator );
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
     * @return QueueValidator
     */
    public function getQueueValidator()
    {
        return $this->queueValidator;
    }

    /**
     * @param QueueValidator $queueValidator
     */
    public function setQueueValidator( QueueValidator $queueValidator )
    {
        $this->queueValidator = $queueValidator;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param QueueModel queue
     * @return QueueModel Added Queue
     * @throws ValidatorException
     */
    public function handle( QueueModel $queue )
    {

        // Get duplicate Queue
        $queueDuplicated = $this->getCampusguideHandler()->getQueueDao()->getDuplicate( $queue );

        // Is duplicated
        if ( $queueDuplicated )
        {

            // Merge arguments
            $queueDuplicated->setArguments(
                    QueueUtil::mergeArguments( $queueDuplicated->getArguments(), $queue->getArguments() ) );

            // Set priority
            $queueDuplicated->setPriority( $queue->getPriority() );

            // Increase occurence
            $queueDuplicated->setOccurence( $queueDuplicated->getOccurence() + 1 );

            // Validate Queue
            $this->getQueueValidator()->doValidate( $queueDuplicated, "Queue is not valid" );

            // Edit Queue
            $this->getCampusguideHandler()->getQueueDao()->edit( $queueDuplicated->getId(),
                    $queueDuplicated );

            // Return edited Queue
            return $this->getCampusguideHandler()->getQueueDao()->get( $queueDuplicated->getId() );

        }
        // Not duplicated
        else
        {

            // Validate Queue
            $this->getQueueValidator()->doValidate( $queue, "Queue is not valid" );

            // Add Queue
            $queueId = $this->getCampusguideHandler()->getQueueDao()->add( $queue );

            // Return added Queue
            return $this->getCampusguideHandler()->getQueueDao()->get( $queueId );

        }

    }

    // /FUNCTIONS


}

?>