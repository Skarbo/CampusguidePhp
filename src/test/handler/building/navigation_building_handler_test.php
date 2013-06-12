<?php

class NavigationBuildingHandlerTest extends DaoTest
{

    // VARIABLES


    /**
     * @var NavigationBuildingHandler
     */
    private $navigationBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "NavigationBuildingHandler Test" );

        $this->navigationBuildingHandler = new NavigationBuildingHandler( $this->getDaoContainerTest() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testShouldHandleAddNavigation()
    {

        // Add Facility
        $facility = $this->getDaoContainerTest()->addFacility();

        // Add Building
        $building = $this->getDaoContainerTest()->addBuilding( $facility->getId() );

        // Add Floor
        $floor = $this->getDaoContainerTest()->addFloor( $building->getId() );

        // Anchors
        $anchors = array ( 1 => array ( "id" => 1, "x" => 100, "y" => 200 ),
                2 => array ( "id" => 2, "x" => 300, "y" => 400 ), 3 => array ( "id" => 3, "x" => 500, "y" => 600 ) );

        // Relationships
        $relationships = array ( 1 => array ( 2, 3 ), 3 => array ( 2 ) );

        // Handle Navigation
        $this->navigationBuildingHandler->handle( $floor->getId(), $anchors, $relationships );

        // Get Nodes
        $nodes = $this->getDaoContainerTest()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        $this->assertEqual( 3, $nodes->size() );

        $nodeFirst = NodeNavigationBuildingModel::get_( $nodes->get( 0 ) );
        $nodeSecond = NodeNavigationBuildingModel::get_( $nodes->get( 1 ) );
        $nodeThird = NodeNavigationBuildingModel::get_( $nodes->get( 2 ) );
        $this->assertEqual( $nodeFirst->getEdges(), array ( $nodeSecond->getId(), $nodeThird->getId() ) );

    }

    public function testShouldHandleUpdateNavigation()
    {

        // Add Navigation
        $this->testShouldHandleAddNavigation();

        // Get Floors
        $floors = $this->getDaoContainerTest()->getFloorBuildingDao()->getAll();
        $floor = $floors->get( 0 );

        // Get Nodes
        $nodes = $this->getDaoContainerTest()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        // Anchors
        $anchors = array (
                1 => array ( "id" => 1, "x" => 100, "y" => 200, "nodeId" => $nodes->get( 0 )->getId() ),
                2 => array ( "id" => 2, "x" => 300, "y" => 400, "nodeId" => $nodes->get( 1 )->getId() ),
                3 => array ( "id" => 3, "x" => 700, "y" => 800, "nodeId" => $nodes->get( 2 )->getId() ) );

        // Relationships
        $relationships = array ( 1 => array ( 2 ), 3 => array ( 1, 2 ) );

        // Handle Navigation
        $this->navigationBuildingHandler->handle( $floor->getId(), $anchors, $relationships );

        // Get Nodes
        $nodes = $this->getDaoContainerTest()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        $this->assertEqual( 3, $nodes->size() );

        $nodeFirst = NodeNavigationBuildingModel::get_( $nodes->get( 0 ) );
        $nodeSecond = NodeNavigationBuildingModel::get_( $nodes->get( 1 ) );
        $nodeThird = NodeNavigationBuildingModel::get_( $nodes->get( 2 ) );
        $this->assertEqual( $nodeFirst->getEdges(), array ( $nodeSecond->getId() ) );
        $this->assertEqual( $nodeThird->getEdges(), array ( $nodeFirst->getId(), $nodeSecond->getId() ) );
        $this->assertEqual( $nodeThird->getCoordinate(), array ( "x" => 700, "y" => 800 ) );

    }

    public function testShouldHandleDeleteNavigation()
    {

        // Add Navigation
        $this->testShouldHandleAddNavigation();

        // Get Floors
        $floors = $this->getDaoContainerTest()->getFloorBuildingDao()->getAll();
        $floor = $floors->get( 0 );

        // Get Nodes
        $nodes = $this->getDaoContainerTest()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        // Anchors
        $anchors = array (
                1 => array ( "id" => 1, "x" => 100, "y" => 200, "nodeId" => $nodes->get( 0 )->getId() ),
                2 => array ( "id" => 2, "x" => 300, "y" => 400, "nodeId" => $nodes->get( 1 )->getId(), "deleted" => true ),
                3 => array ( "id" => 3, "x" => 700, "y" => 800, "nodeId" => $nodes->get( 2 )->getId() ) );

        // Relationships
        $relationships = array ( 1 => array ( 3 ) );

        // Handle Navigation
        $this->navigationBuildingHandler->handle( $floor->getId(), $anchors, $relationships );

        // Get Nodes
        $nodes = $this->getDaoContainerTest()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        $this->assertEqual( 2, $nodes->size() );

        $nodeFirst = NodeNavigationBuildingModel::get_( $nodes->get( 0 ) );
        $nodeSecond = NodeNavigationBuildingModel::get_( $nodes->get( 1 ) );
        $this->assertEqual( $nodeFirst->getEdges(), array ( $nodeSecond->getId() ) );
        $this->assertEqual( $nodeSecond->getCoordinate(), array ( "x" => 700, "y" => 800 ) );

    }

    //     public function testShouldHandleEditNavigations()
    //     {


    //         // Add Facility
    //         $facility = $this->getDaoContainerTest()->addFacility();


    //         // Add Building
    //         $building = $this->getDaoContainerTest()->addBuilding( $facility->getId() );


    //         // Add Navigations
    //         $navigationOne = NavigationBuildingFactoryModel::createNavigationBuilding( $building->getId(), "First Navigation", 0,
    //                 array ( array ( 100, 200 ), array ( 300, 400 ) ) );
    //         $navigationTwo = NavigationBuildingFactoryModel::createNavigationBuilding( $building->getId(), "Second Navigation", 1,
    //                 array ( array ( 100, 200 ), array ( 300, 400 ) ) );
    //         $navigationThree = NavigationBuildingFactoryModel::createNavigationBuilding( $building->getId(), "Third Navigation", 2,
    //                 array ( array ( 100, 200 ), array ( 300, 400 ) ) );


    //         $navigationOne->setId(
    //                 $this->getDaoContainerTest()->getnavigationBuildingDao()->addNavigationBuilding( $building->getId(),
    //                         $navigationOne ) );
    //         $navigationTwo->setId(
    //                 $this->getDaoContainerTest()->getnavigationBuildingDao()->addNavigationBuilding( $building->getId(),
    //                         $navigationTwo ) );
    //         $navigationThree->setId(
    //                 $this->getDaoContainerTest()->getnavigationBuildingDao()->addNavigationBuilding( $building->getId(),
    //                         $navigationThree ) );


    //         // Edit Navigations
    //         $navigationOne->setName( "Navigation First Updated" );
    //         $navigationTwo->setName( "Navigation Second Updated" );
    //         $navigationThree->setName( "Navigation Third Updated" );


    //         // Handle edit Navigation
    //         $navigationsEditedArray = array ( $navigationTwo, $navigationThree, $navigationOne );
    //         $navigationsEdited = new NavigationBuildingListModel( $navigationsEditedArray );


    //         $navigationsHandled = $this->navigationBuildingHandler->handleEditNavigations( $building->getId(), $navigationsEdited );


    //         // Assert handled Navigations
    //         if ( $this->assertEqual( count( $navigationsEditedArray ), $navigationsHandled->size(),
    //                 sprintf( "Handled navigations size should be \"%d\" but is \"%d\"", count( $navigationsEditedArray ),
    //                         $navigationsHandled->size() ) ) )
    //         {
    //             for ( $i = 0; $i < count( $navigationsEditedArray ); $i++ )
    //             {
    //                 $navigationEdited = NavigationBuildingModel::get_( $navigationsEditedArray[ $i ] );
    //                 $navigationHandled = $navigationsHandled->getId( $navigationEdited->getId() );


    //                 if ( $this->assertNotNull( $navigationHandled,
    //                         sprintf( "Handled navigation (index #%d) should not be null", $i ) ) )
    //                 {
    //                     $this->assertEqual( $i, $navigationHandled->getOrder(),
    //                             sprintf( "Handled Navigation order should be \"%d\" but is \"%d\"", $i,
    //                                     $navigationHandled->getOrder() ) );
    //                     $this->assertEqual( $navigationEdited->getName(), $navigationHandled->getName(),
    //                             sprintf( "Handled Navigation order should be \"%d\" but is \"%d\"", $navigationEdited->getName(),
    //                                     $navigationHandled->getName() ) );
    //                 }
    //             }


    //         }


    //     }


    // /FUNCTIONS


}

?>