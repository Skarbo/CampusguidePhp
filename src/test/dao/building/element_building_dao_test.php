<?php

class ElementBuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "ElementBuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getelementBuildingDao();
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $model = ElementBuildingModel::get_( $model );

        $model->setName( "Updated Element" );
        $model->setCoordinates( array ( array ( array ( 300, 400, "L" ), array ( 500, 600, "L" ) ) ) );

        return $model;

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

        // Add Floor
        $floor = $this->getDaoContainerTest()->addFloor( $building->getId() );

        // Add Section
        $section = $this->getDaoContainerTest()->addSection( $building->getId() );

        // Create Element
        return DaoContainerTest::createElementBuildingTest( $floor->getId(), $section->getId() );
    }

    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = ElementBuildingModel::get_( $modelOne );
        $modelTwo = ElementBuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getFloorId(), $modelTwo->getFloorId(), "Element Building floor id",
                $this );
        self::assertEqualsFunction( $modelOne->getSectionId(), $modelTwo->getSectionId(),
                "Element Building section id", $this );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Element Building name", $this );
        self::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Element Building coordinates", $this );

    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = ElementBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getFloorId(), "Element Building floor id", $this );
        self::assertNotNullFunction( $model->getSectionId(), "Element Building section id", $this );
        self::assertNotNullFunction( $model->getName(), "Element Building name", $this );
        self::assertNotNullFunction( $model->getCoordinates(), "Element Building coordinates", $this );

    }

    /**
     * @see StandardDaoTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        $model = ElementBuildingModel::get_( $model );
        return $model->getName();
    }

    public function testShouldGetBuilding()
    {

        // Create test model
        $model = ElementBuildingModel::get_( $this->createModelTest() );

        $floor = $this->getDaoContainerTest()->getfloorBuildingDao()->get( $model->getForeignId() );

        // Add Models
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );
        $this->getStandardDao()->add( $model, $model->getForeignId() );

        // Get foreign List
        $modelRetrievedForeignList = $this->getStandardDao()->getBuilding( $floor->getForeignId() );

        // Assert foreign list
        $this->assertEqual( 3, $modelRetrievedForeignList->size(),
                sprintf( "Retrieved Foreign %s should be size %d but is %d", get_class( $model ), 3,
                        $modelRetrievedForeignList->size() ) );

    }

    // /FUNCTIONS


}

?>