<?php

class FloorBuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "FloorBuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getfloorBuildingDao();
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $modelEdited = FloorBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Floor" );
        $modelEdited->setOrder( $modelEdited->getOrder() + 1 );
        $modelEdited->setMain( true );

        return $modelEdited;
    }

    /**
     * @see StandardDaoTest::createModelTest()
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

    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = FloorBuildingModel::get_( $modelOne );
        $modelTwo = FloorBuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getBuildingId(), $modelTwo->getBuildingId(),
                "Floor Building building id", $this );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Floor Building name", $this );
        self::assertEqualsFunction( $modelOne->getOrder(), $modelTwo->getOrder(), "Floor Building foreign id", $this );
        self::assertEqualsFunction( $modelOne->getMain(), $modelTwo->getMain(), "Floor Building main id", $this );
        self::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Floor Building coordinates", $this );

    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = FloorBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Floor Building id", $this );
        self::assertNotNullFunction( $model->getBuildingId(), "Floor Building building id", $this );
        self::assertNotNullFunction( $model->getName(), "Floor Building name", $this );
        self::assertNotNullFunction( $model->getOrder(), "Floor Building order", $this );
        self::assertNotNullFunction( $model->getMain(), "Floor Building main", $this );
        self::assertNotNullFunction( $model->getCoordinates(), "Floor Building order", $this );

    }

    /**
     * @see StandardDaoTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        // TODO Auto-generated method stub


    }

    // /FUNCTIONS


}

?>