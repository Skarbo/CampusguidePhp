<?php

class FacilitiesRestControllerTest extends StandardRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "FacilitiesCampsguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new FacilityModel( $array );
    }

    /**
     * @see StandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new FacilityListModel();
    }

    /**
     * @see StandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return FacilitiesRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = FacilityModel::get_( $model );

        $model->setName( "Updated Name" );

        return $model;
    }

    /**
     * @see StandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getfacilityDao();
    }

    /**
     * @see StandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = FacilityModel::get_( $modelOne );
        $modelTwo = FacilityModel::get_( $modelTwo );

        StandardDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Facility name", $testCase );
    }

    /**
     * @see StandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = FacilityModel::get_( $model );

        StandardDaoTest::assertNotNullFunction( $model->getId(), "Facility id", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getName(), "Facility name", $testCase );
    }

    /**
     * @see StandardRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return DaoContainerTest::createFacilityTest();
    }

    /**
     * @see StandardRestControllerTest::testShouldGetListForeign()
     */
    public function testShouldGetListForeign()
    {
        // Overwritten
    }

    /**
     * @see StandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        // TODO Auto-generated method stub


    }

    // /FUNCTIONS


}

?>