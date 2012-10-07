<?php

class QueueCmsPresenterView extends AbstractPresenterView
{

    // VARIABLES


    private static $ID_QUEUE_WRAPPER = "queue_wrapper";
    private static $ID_QUEUE = "queue";

    /**
     * @var QueueModel
     */
    private $queue;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view, QueueModel $queue )
    {
        parent::__construct( $view );

        $this->setQueue( $queue );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return QueueModel
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param QueueModel $queeu
     */
    public function setQueue( QueueModel $queue )
    {
        $this->queue = $queue;
    }

    // ... /GETTERS/SETTERS


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( self::$ID_QUEUE_WRAPPER );

        // Add queue element to wrapper
        $wrapper->addContent( Xhtml::div()->id( self::$ID_QUEUE ) );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

?>