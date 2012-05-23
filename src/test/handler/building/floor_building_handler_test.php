<?php

class FloorBuildingHandlerTest extends CampusguideDaoTest
{

    // VARIABLES


    /**
     * @var FloorBuildingHandler
     */
    private $floorBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "FloorBuildingHandler Test" );

        $this->floorBuildingHandler = new FloorBuildingHandler( $this->floorBuildingDao,
                new FloorBuildingValidator( Locale::instance() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testShouldHandleAddFloor()
    {

        // Add Facility
        $facility = $this->addFacility();

        // Add Building
        $building = $this->addBuilding( $facility->getId() );

        // Add Floor
        $floor = $this->addFloor( $building->getId() );

        // Create Floor
        $floorSecond = FloorBuildingFactoryModel::createFloorBuilding( $building->getId(), "Second Floor", 2,  array ( array ( 100, 200 ), array ( 300, 400 ) ) );

        // Handle add Floor
        $floorHandled = $this->floorBuildingHandler->handleAddFloor( $building->getId(), $floorSecond );

        // Assert handled Floor
        if ( $this->assertNotNull( $floorHandled, "Handled Floor should not be null" ) )
        {
            $this->assertEqual( $floor->getOrder() + 1, $floorHandled->getOrder(),
                    sprintf( "Handled Floor order should be  \"%d\" but is \"%d\"", $floor->getOrder() + 1,
                            $floorHandled->getOrder() ) );
        }

    }

    public function testShouldHandleEditFloors()
    {

        // Add Facility
        $facility = $this->addFacility();

        // Add Building
        $building = $this->addBuilding( $facility->getId() );

        // Add Floors
        $floorOne = FloorBuildingFactoryModel::createFloorBuilding( $building->getId(), "First Floor", 0,  array ( array ( 100, 200 ), array ( 300, 400 ) ) );
        $floorTwo = FloorBuildingFactoryModel::createFloorBuilding( $building->getId(), "Second Floor", 1,  array ( array ( 100, 200 ), array ( 300, 400 ) ) );
        $floorThree = FloorBuildingFactoryModel::createFloorBuilding( $building->getId(), "Third Floor", 2,  array ( array ( 100, 200 ), array ( 300, 400 ) ) );

        $floorOne->setId( $this->floorBuildingDao->addFloorBuilding( $building->getId(), $floorOne ) );
        $floorTwo->setId( $this->floorBuildingDao->addFloorBuilding( $building->getId(), $floorTwo ) );
        $floorThree->setId( $this->floorBuildingDao->addFloorBuilding( $building->getId(), $floorThree ) );

        // Edit Floors
        $floorOne->setName( "Floor First Updated" );
        $floorTwo->setName( "Floor Second Updated" );
        $floorThree->setName( "Floor Third Updated" );

        // Handle edit Floor
        $floorsEditedArray = array ( $floorTwo, $floorThree, $floorOne );
        $floorsEdited = new FloorBuildingListModel( $floorsEditedArray );

        $floorsHandled = $this->floorBuildingHandler->handleEditFloors( $building->getId(), $floorsEdited );

        // Assert handled Floors
        if ( $this->assertEqual( count( $floorsEditedArray ), $floorsHandled->size(),
                sprintf( "Handled floors size should be \"%d\" but is \"%d\"", count( $floorsEditedArray ),
                        $floorsHandled->size() ) ) )
        {
            for ( $i = 0; $i < count( $floorsEditedArray ); $i++ )
            {
                $floorEdited = FloorBuildingModel::get_( $floorsEditedArray[ $i ] );
                $floorHandled = $floorsHandled->getId( $floorEdited->getId() );

                if ( $this->assertNotNull( $floorHandled,
                        sprintf( "Handled floor (index #%d) should not be null", $i ) ) )
                {
                    $this->assertEqual( $i, $floorHandled->getOrder(),
                            sprintf( "Handled Floor order should be \"%d\" but is \"%d\"", $i,
                                    $floorHandled->getOrder() ) );
                    $this->assertEqual( $floorEdited->getName(), $floorHandled->getName(),
                            sprintf( "Handled Floor order should be \"%d\" but is \"%d\"", $floorEdited->getName(),
                                    $floorHandled->getName() ) );
                }
            }

        }

    }

    // /FUNCTIONS


}

?>