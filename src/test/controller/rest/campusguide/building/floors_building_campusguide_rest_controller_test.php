<?php

class FloorsBuildingCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
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
                implode( StandardCampusguideRestController::$ID_SPLITTER,
                        array_map(
                                function ( $var )
                                {
                                    return urlencode( $var );
                                }, $ids ) ) );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new FloorBuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return FloorsBuildingCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new FloorBuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = FloorBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Floor" );
        $modelEdited->setOrder( $modelEdited->getOrder() + 1 );

        return $modelEdited;

    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->floorBuildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
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

    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = FloorBuildingModel::get_( $model );

        FloorBuildingDaoTest::assertNotNullFunction( $model->getId(), "Floor Building id", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getBuildingId(), "Floor Building building id", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getName(), "Floor Building name", $testCase );
        FloorBuildingDaoTest::assertNotNullFunction( $model->getOrder(), "Floor Building order", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
     * @return FloorBuildingModel
     */
    protected function createModelTest()
    {

        // Add Facility
        $facility = $this->addFacility();

        // Add Building
        $building = $this->addBuilding( $facility->getId() );

        // Create Floor Building
        return FloorBuildingDaoTest::createFloorBuildingTest( $building->getId() );

    }

    private function createPostModelList( FloorBuildingListModel $floors )
    {
        return array (
                FloorsBuildingCampusguideRestController::$POST_OBJECTS => array_map(
                        function ( $var )
                        {
                            return get_object_vars( $var );
                        }, $floors->getArray() ) );
    }

    // ... TEST


    public function testShouldEditMultiple()
    {

        // Add Facility
        $facility = $this->addFacility();

        // Add Building
        $building = $this->addBuilding( $facility->getId() );

        // Add floors
        $floors = new FloorBuildingListModel();
        $floors->add( $this->addFloor( $building->getId() ) );
        $floors->add( $this->addFloor( $building->getId() ) );
        $floors->add( $this->addFloor( $building->getId() ) );

        // Edit Floors
        $floors->get( 0 )->setName( "Updated Floor One" );
        $floors->get( 1 )->setName( "Updated Floor Two" );
        $floors->get( 2 )->setName( "Updated Floor Three" );

        // Shuffle Floors
        $floors->shuffle();

        // Get Website
        $url = self::getRestWebsite( $this->getQueryEditMultiple( $floors->getIds() ) );

        // Do POST
        $data = $this->post( $url, $this->createPostModelList( $floors ) );
        $dataArray = json_decode( $data, true );

        $this->showHeaders();
        $this->showRequest();
        $this->showSource();

        // Assert response
        $this->assertResponse( Controller::STATUS_CREATED, "Should be correct response" );

        // Get REST Floor list
        $floorsRest = $this->getRestModelList( Core::arrayAt( $dataArray, StandardCampusguideRestView::$FIELD_LIST, array() ) );

        // Assert Model list
        if ( $this->assertEqual( $floors->size(), $floorsRest->size(),
                sprintf( "Model list REST size should be \"%d\" but is \"%d\"", $floors->size(), $floorsRest->size() ) ) )
        {
            // Assert the order
            for ( $i = 0; $i < $floors->size(); $i++ )
            {
                $floor = $floors->get( $i );
                $floorRest = $floorsRest->getId( $floor->getId() );

                if ( $this->assertFalse( is_null( $floorRest ),
                        sprintf( "Floor REST id \"%d\" should not be null", $floor->getId() ) ) )
                {
                    $this->assertEqual( $i, $floorRest->getOrder(),
                            sprintf( "Floor order should be \"%d\" but is \"%d\"", $i, $floorRest->getOrder() ) );
                }

            }

        }

    }

    // ... /TEST


    // /FUNCTIONS


}

?>