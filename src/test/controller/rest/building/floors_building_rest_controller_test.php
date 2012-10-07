<?php

class FloorsBuildingRestControllerTest extends StandardRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "FloorBuildingCampsguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    private function getQueryEditMultiple( array $ids )
    {
        return sprintf( self::$QUERY_POST_SINGLE_EDIT, $this->getControllerName(),
                implode( StandardRestController::$ID_SPLITTER,
                        array_map(
                                function ( $var )
                                {
                                    return urlencode( $var );
                                }, $ids ) ) );
    }

    /**
     * @see StandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new FloorBuildingListModel();
    }

    /**
     * @see StandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return FloorsBuildingRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new FloorBuildingModel( $array );
    }

    /**
     * @see StandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = FloorBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Floor" );
        $modelEdited->setOrder( $modelEdited->getOrder() + 1 );

        return $modelEdited;

    }

    /**
     * @see StandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getfloorBuildingDao();
    }

    /**
     * @see StandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = FloorBuildingModel::get_( $modelOne );
        $modelTwo = FloorBuildingModel::get_( $modelTwo );

        FloorBuildingDaoTest::assertEqualsFunction( $modelOne->getBuildingId(), $modelTwo->getBuildingId(),
                "Floor Building building id", $testCase );
        FloorBuildingDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Floor Building name",
                $testCase );
        FloorBuildingDaoTest::assertEqualsFunction( $modelOne->getOrder(), $modelTwo->getOrder(),
                "Floor Building foreign id", $testCase );
        FloorBuildingDaoTest::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Floor Building coordinates", $testCase );

    }

    /**
     * @see StandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = FloorBuildingModel::get_( $model );

        FloorBuildingDaoTest::assertNotNullFunction( $model->getId(), "Floor Building id", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getBuildingId(), "Floor Building building id", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getName(), "Floor Building name", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getOrder(), "Floor Building order", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getMain(), "Floor Building main", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getCoordinates(), "Floor Building main", $testCase );
    }

    /**
     * @see StandardRestControllerTest::createModelTest()
     * @return FloorBuildingModel
     */
    protected function createModelTest()
    {

        // Add Facility
        $facility = $this->getDaoContainerTest()->addFacility();

        // Add Building
        $building = $this->getDaoContainerTest()->addBuilding( $facility->getId() );

        // Create Floor Building
        return DaoContainerTest::createFloorBuildingTest( $building->getId() );

    }

    //     private function createPostModelList( FloorBuildingListModel $floors )
    //     {
    //         return array (
    //                 FloorsBuildingRestController::$POST_OBJECTS => array_map(
    //                         function ( $var )
    //                         {
    //                             return get_object_vars( $var );
    //                         }, $floors->getArray() ) );
    //     }


    // ... TEST


    //     public function testShouldEditMultiple()
    //     {


    //         // Add Facility
    //         $facility = $this->getDaoContainerTest()->addFacility();


    //         // Add Building
    //         $building = $this->getDaoContainerTest()->addBuilding( $facility->getId() );


    //         // Add floors
    //         $floors = new FloorBuildingListModel();
    //         $floors->add( $this->getDaoContainerTest()->addFloor( $building->getId() ) );
    //         $floors->add( $this->getDaoContainerTest()->addFloor( $building->getId() ) );
    //         $floors->add( $this->getDaoContainerTest()->addFloor( $building->getId() ) );


    //         // Edit Floors
    //         $floors->get( 0 )->setName( "Updated Floor One" );
    //         $floors->get( 1 )->setName( "Updated Floor Two" );
    //         $floors->get( 2 )->setName( "Updated Floor Three" );


    //         // Shuffle Floors
    //         $floors->shuffle();


    //         // Get Website
    //         $url = self::getRestWebsite( $this->getQueryEditMultiple( $floors->getIds() ) );


    //         // Do POST
    //         $data = $this->post( $url, $this->createPostModelList( $floors ) );
    //         $dataArray = json_decode( $data, true );


    //         $this->showHeaders();
    //         $this->showRequest();
    //         $this->showSource();


    //         // Assert response
    //         $this->assertResponse( AbstractController::STATUS_CREATED, "Should be correct response" );


    //         // Get REST Floor list
    //         $floorsRest = $this->getRestModelList( Core::arrayAt( $dataArray, StandardRestView::$FIELD_LIST, array() ) );


    //         // Assert Model list
    //         if ( $this->assertEqual( $floors->size(), $floorsRest->size(),
    //                 sprintf( "Model list REST size should be \"%d\" but is \"%d\"", $floors->size(), $floorsRest->size() ) ) )
    //         {
    //             // Assert the order
    //             for ( $i = 0; $i < $floors->size(); $i++ )
    //             {
    //                 $floor = $floors->get( $i );
    //                 $floorRest = $floorsRest->getId( $floor->getId() );


    //                 if ( $this->assertFalse( is_null( $floorRest ),
    //                         sprintf( "Floor REST id \"%d\" should not be null", $floor->getId() ) ) )
    //                 {
    //                     $this->assertEqual( $i, $floorRest->getOrder(),
    //                             sprintf( "Floor order should be \"%d\" but is \"%d\"", $i, $floorRest->getOrder() ) );
    //                 }


    //             }


    //         }


    //     }


    /**
     * @see StandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        $model = FloorBuildingModel::get_( $model );

        return $model->getName();
    }

    // ... /TEST


    // /FUNCTIONS


}

?>