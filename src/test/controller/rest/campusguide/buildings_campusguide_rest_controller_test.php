<?php

class BuildingsCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
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
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new BuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return BuildingsCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new BuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = BuildingModel::get_( $model );

        $model->setName( "Updated Building" );

        return $model;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->buildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return BuildingModel::get_( $model )->getName();
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = BuildingModel::get_( $modelOne );
        $modelTwo = BuildingModel::get_( $modelTwo );

        StandardDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Building name", $testCase );
        StandardDaoTest::assertEqualsFunction( $modelOne->getFacilityId(), $modelTwo->getFacilityId(),
                "Building Facility id", $testCase );
        StandardDaoTest::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Building coordinates", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = BuildingModel::get_( $model );

        StandardDaoTest::assertNotNullFunction( $model->getIdURI(), "Building id", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getName(), "Building name", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getFacilityId(), "Building Facility id", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getCoordinates(), "Building coordinates", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        // Add Facility
        $facility = $this->addFacility();

        return BuildingDaoTest::createBuildingTest( $facility->getId() );
    }

    // /FUNCTIONS


}

?>