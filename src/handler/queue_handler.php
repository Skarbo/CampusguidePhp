<?php

class QueueHandler extends Handler
{

    // VARIABLES


    /**
     * @var QueueDao
     */
    private $queueDao;
    /**
     * @var QueueValidator
     */
    private $queueValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( QueueDao $queueDao, QueueValidator $queueValidator )
    {
        $this->setQueueDao( $queueDao );
        $this->setQueueValidator( $queueValidator );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return QueueDao
     */
    public function getQueueDao()
    {
        return $this->queueDao;
    }

    /**
     * @param QueueDao $queueDao
     */
    public function setQueueDao( QueueDao $queueDao )
    {
        $this->queueDao = $queueDao;
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
        $queueDuplicated = $this->getQueueDao()->getDuplicate( $queue );

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
            $this->getQueueDao()->edit( $queueDuplicated->getId(), $queueDuplicated );

            // Return edited Queue
            return $this->getQueueDao()->get( $queueDuplicated->getId() );

        }
        // Not duplicated
        else
        {

            // Validate Queue
            $this->getQueueValidator()->doValidate( $queue, "Queue is not valid" );

            // Add Queue
            $queueId = $this->getQueueDao()->add( $queue );

            // Return added Queue
            return $this->getQueueDao()->get( $queueId );

        }

    }

    // /FUNCTIONS


}

?>