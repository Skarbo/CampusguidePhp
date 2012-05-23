<?php

class FacilityDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "FacilityDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->facilityDao;
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = FacilityModel::get_( $model );
        $modelEdited->setName( "Facility Edited" );

        return $modelEdited;

    }

    /**
     * @see StandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        return self::createFacilityTest();
    }

    // ... /GET


    // ... ASSERT


    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = FacilityModel::get_( $modelOne );
        $modelTwo = FacilityModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getId(), $modelTwo->getId(), "Facility id", $testCase );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Facility name", $testCase );
    }

    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = FacilityModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Facility id", $testCase );
        self::assertNotNullFunction( $model->getName(), "Facility name", $testCase );
    }

    // ... /ASSERT


    public function testShouldGetForeign()
    {
        // Foreign not supported
    }

    // /FUNCTIONS


}

?>