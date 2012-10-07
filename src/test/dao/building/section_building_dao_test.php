<?php

class SectionBuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "SectionBuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getsectionBuildingDao();
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = SectionBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Section" );
        $modelEdited->setCoordinates( array ( array ( array ( 500, 600 ), array ( 700, 800 ) ) ) );

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

        // Create Section Building
        return DaoContainerTest::createSectionBuildingTest( $building->getId() );

    }

    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = SectionBuildingModel::get_( $modelOne );
        $modelTwo = SectionBuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getBuildingId(), $modelTwo->getBuildingId(), "Section Building id",
                $this );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Section Building name", $this );
        self::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Section Building coordinates", $this );
    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = SectionBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Section Building id", $this );
        self::assertNotNullFunction( $model->getBuildingId(), "Section Building building id", $this );
        self::assertNotNullFunction( $model->getName(), "Section Building name", $this );
        self::assertNotNullFunction( $model->getCoordinates(), "Section Building coordinates", $this );

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