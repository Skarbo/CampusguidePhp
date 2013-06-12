<?php

class NavigateHandlerTest extends UnitTestCase
{

    // VARIABLES


    private $navigateHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "NavigateHandler Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS
    /**
     * @see AbstractDbTest::setUp()
     */
    public function setUp()
    {
        parent::setUp();

        $this->navigateHandler = new NavigateHandler();
    }

    public function testShouldGetTheShortestNavigationPath()
    {

        $floor = FloorBuildingFactoryModel::createFloorBuilding( 0, "Floor", 0, array () );
        $floor->setId( 1 );
        $element = ElementBuildingFactoryModel::createElementBuilding( $floor->getId(), "Element", array () );
        $element->setId( 1 );

        $nodes = new NodeNavigationBuildingListModel();

        $node1 = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floor->getId(),
                array ( "x" => 100, "y" => 200 ) );
        $node1->setId( 11 );
        $nodes->add( $node1 );

        $node2 = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floor->getId(),
                array ( "x" => 300, "y" => 400 ) );
        $node2->setId( 22 );
        $nodes->add( $node2 );

        $node3 = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floor->getId(),
                array ( "x" => 500, "y" => 600 ) );
        $node3->setId( 33 );
        $nodes->add( $node3 );

        $node4 = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floor->getId(),
                array ( "x" => 700, "y" => 800 ), $element->getId() );
        $node4->setId( 44 );
        $nodes->add( $node4 );

        $node1->setEdges( array ( $node2->getId() ) );
        $node2->setEdges( array ( $node3->getId() ) );
        $node3->setEdges( array ( $node4->getId() ) );

        $position = array ( "x" => 80, "y" => 170 );

        $navigate = $this->navigateHandler->handle( $element, $position, $floor, $nodes );

        if ( $this->assertNotNull( $navigate ) )
        {
            $this->assertEqual( array ( $node1->getId(), $node2->getId(), $node3->getId(), $node4->getId() ),
                    $navigate );
        }

    }

    public function testShouldGetClosestNodeFromPoint()
    {

        $point = array ( "x" => 460, "y" => 466 );

        $nodes = new NodeNavigationBuildingListModel();

        $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( 0, array ( "x" => 200, "y" => 200 ) );
        $node->setId( 1 );
        $nodes->add( $node );

        $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( 0, array ( "x" => 300, "y" => 300 ) );
        $node->setId( 2 );
        $nodes->add( $node );

        $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( 0, array ( "x" => 400, "y" => 400 ) );
        $node->setId( 3 );
        $nodes->add( $node );

        $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( 0, array ( "x" => 500, "y" => 500 ) );
        $node->setId( 4 );
        $nodes->add( $node );

        $closestNode = $this->navigateHandler->getClosestNodeFromPoint( $point, $nodes );

        if ( $this->assertNotNull( $closestNode ) )
        {
            $this->assertEqual( 4, $closestNode->getId() );
        }

    }

    // /FUNCTIONS


}

?>