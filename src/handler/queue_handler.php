<?php

class QueueHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;
    /**
     * @var QueueValidator
     */
    private $queueValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer, QueueValidator $queueValidator )
    {
        $this->setDaoContainer( $daoContainer );
        $this->setQueueValidator( $queueValidator );
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
        $queueDuplicated = $this->getDaoContainer()->getQueueDao()->getDuplicate( $queue );

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
            $this->getDaoContainer()->getQueueDao()->edit( $queueDuplicated->getId(),
                    $queueDuplicated );

            // Return edited Queue
            return $this->getDaoContainer()->getQueueDao()->get( $queueDuplicated->getId() );

        }
        // Not duplicated
        else
        {

            // Validate Queue
            $this->getQueueValidator()->doValidate( $queue, "Queue is not valid" );

            // Add Queue
            $queueId = $this->getDaoContainer()->getQueueDao()->add( $queue );

            // Return added Queue
            return $this->getDaoContainer()->getQueueDao()->get( $queueId );

        }

    }

    // /FUNCTIONS


}

?>