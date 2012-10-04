<?php

class QueueHandlerTest extends DbTest
{

    // VARIABLES


    /**
     * @var QueueDao
     */
    private $queueDao;
    /**
     * @var QueueHandler
     */
    private $queueHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "QueueHandler Test" );

        $this->queueDao = new QueueDbDao( $this->getDbApi() );
        $this->queueHandler = new QueueHandler( new CampusguideHandler($this->getDbApi()), new QueueValidator( Locale::instance() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->queueDao->removeAll();
    }

    public function testShouldHandleQueue()
    {

        // Create Queue
        $queue = QueueFactoryModel::createQueue( QueueModel::TYPE_IMAGE_BUILDING, QueueModel::PRIORITY_MEDIUM,
                array ( "field" => "value", "field2" => array ( "value2", "value3" ), "field3" => "value4" ) );

        // Handle add Queue
        $queueAdded = $this->queueHandler->handle( $queue );

        // Assert added Queue
        if ( $this->assertNotNull( $queueAdded, "Queue added should not be null" ) )
        {
            $this->assertEqual( $queue->getType(), $queueAdded->getType(),
                    sprintf( "Queue type should be \"%s\" but is \"%s\"", $queue->getType(), $queueAdded->getType() ) );
            $this->assertEqual( $queue->getArguments(), $queueAdded->getArguments(),
                    sprintf( "Queue arguments should be \"%s\" but is \"%s\"", print_r( $queue->getArguments(), true ),
                            print_r( $queueAdded->getArguments(), true ) ) );
            $this->assertEqual( $queue->getPriority(), $queueAdded->getPriority(),
                    sprintf( "Queue priority should be \"%s\" but is \"%s\"", $queue->getPriority(),
                            $queueAdded->getPriority() ) );
        }

        // Create new Queue
        $queueNew = QueueFactoryModel::createQueue( QueueModel::TYPE_IMAGE_BUILDING,
                QueueModel::PRIORITY_MEDIUM,
                array ( "field" => "valueUpdated", "field2" => array ( "value2", "value3Updated" ),
                        "field3" => array ( "value5" ) ) );

        // Get marged arguments
        $argumentsMerged = QueueUtil::mergeArguments( $queue->getArguments(), $queueNew->getArguments() );

        // Handle edit Queue
        $queueEdited = $this->queueHandler->handle( $queueNew );

        // Assert edited Queue
        if ( $this->assertNotNull( $queueEdited, "Queue edited should not be null" ) )
        {
            $this->assertEqual( $queueAdded->getId(), $queueEdited->getId(),
                    sprintf( "Queue id should be \"%s\" but is \"%s\"", $queueAdded->getId(), $queueEdited->getId() ) );
            $this->assertEqual( $argumentsMerged, $queueEdited->getArguments(),
                    sprintf( "Queue arguments should be \"%s\" but is \"%s\"", print_r( $argumentsMerged, true ),
                            print_r( $queueEdited->getArguments(), true ) ) );
            $this->assertEqual( $queueAdded->getOccurence() + 1, $queueEdited->getOccurence(),
                    sprintf( "Queue occurence should be \"%s\" but is \"%s\"", $queueAdded->getOccurence() + 1,
                            $queueEdited->getOccurence() ) );
        }

    }

    // /FUNCTIONS


}

?>