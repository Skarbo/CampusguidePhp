<?php

class FacilitiesCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
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
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new FacilityModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new FacilityListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return FacilitiesCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $model = FacilityModel::get_( $model );

        $model->setName( "Updated Name" );

        return $model;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->facilityDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = FacilityModel::get_( $modelOne );
        $modelTwo = FacilityModel::get_( $modelTwo );

        StandardDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Facility name", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = FacilityModel::get_( $model );

        StandardDaoTest::assertNotNullFunction( $model->getIdURI(), "Facility id", $testCase );
        StandardDaoTest::assertNotNullFunction( $model->getName(), "Facility name", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return FacilityDaoTest::createFacilityTest();
    }

    /**
     * @see StandardCampusguideRestControllerTest::testShouldGetListForeign()
     */
    public function testShouldGetListForeign()
    {
        // Overwritten
    }

    /**
     * @see StandardCampusguideRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        // TODO Auto-generated method stub


    }

    // /FUNCTIONS


}

?>