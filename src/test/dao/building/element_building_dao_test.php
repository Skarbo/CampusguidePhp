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
        return $this->elementBuildingDao;
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
        $facility = $this->addFacility();

        // Add Building
        $building = $this->addBuilding( $facility->getId() );

        // Add Element Type Group
        $elementTypeGroup = $this->addGroupTypeElement();

        // Add Element Type
        $elementType = $this->addTypeElement( $elementTypeGroup->getId() );

        // Add Floor
        $floor = $this->addFloor( $building->getId() );

        // Add Section
        $section = $this->addSection( $building->getId() );

        // Create Element
        return self::createElementBuildingTest( $floor->getId(), $elementType->getId(), $section->getId() );
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
        self::assertEqualsFunction( $modelOne->getTypeId(), $modelTwo->getTypeId(), "Element Building type id", $this );
        self::assertEqualsFunction( $modelOne->getSectionId(), $modelTwo->getSectionId(),
                "Element Building section id", $this );
        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Element Building name", $this );
        self::assertEqualsFunction( Resource::generateCoordinatesToString( $modelOne->getCoordinates() ),
                Resource::generateCoordinatesToString( $modelTwo->getCoordinates() ), "Element Building coordinates",
                $this );

    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = ElementBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getFloorId(), "Element Building floor id", $this );
        self::assertNotNullFunction( $model->getTypeId(), "Element Building type id", $this );
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

    // /FUNCTIONS


}

?>