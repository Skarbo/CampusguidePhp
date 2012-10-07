<?php

class BuildingsRestControllerTest extends StandardRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "BuildingsCampsguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new BuildingListModel();
    }

    /**
     * @see StandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return BuildingsRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new BuildingModel( $array );
    }

    /**
     * @see StandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = BuildingModel::get_( $model );

        $model->setName( "Updated Building" );

        return $model;
    }

    /**
     * @see StandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getbuildingDao();
    }

    /**
     * @see StandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return BuildingModel::get_( $model )->getName();
    }

    /**
     * @see StandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = BuildingModel::get_( $modelOne );
        $modelTwo = BuildingModel::get_( $modelTwo );

        StandardDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Building name", $testCase );
        StandardDaoTest::assertEqualsFunction( $modelOne->getFacilityId(), $modelTwo->getFacilityId(),
                "Building Facility id", $testCase );
    }

    /**
     * @see StandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = BuildingModel::get_( $model );

        StandardDaoTest::assertNotNullFunction( $model->getId(), "Building id", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getName(), "Building name", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getFacilityId(), "Building Facility id", $testCase );
    }

    /**
     * @see StandardRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        // Add Facility
        $facility = $this->getDaoContainerTest()->addFacility();

        return DaoContainerTest::createBuildingTest( $facility->getId() );
    }

    // /FUNCTIONS


}

?>