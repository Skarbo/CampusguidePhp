<?php

class BuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "BuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getCampusguideHandlerTest()->getbuildingDao();
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $modelEdited = BuildingModel::get_( $model );
        $modelEdited->setName( "Building Edited" );
        $modelEdited->setAddress( array ( "streetname2", "city2", "postal2", "country2" ) );

        return $modelEdited;
    }

    /**
     * @see StandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        // Add Facility
        $facility = $this->getCampusguideHandlerTest()->addFacility();

        return CampusguideHandlerTest::createBuildingTest( $facility->getId() );
    }

    /**
     * @see StandardDaoTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        return BuildingModel::get_( $model )->getName();
    }

    // ... /GET


    // ... ASSERT


    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = BuildingModel::get_( $modelOne );
        $modelTwo = BuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getId(), $modelTwo->getId(), "Building id", $testCase );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Building name", $testCase );
    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = BuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Building id", $testCase );
        self::assertNotNullFunction( $model->getName(), "Building name", $testCase );
    }

    // ... /ASSERT


    // /FUNCTIONS


}

?>