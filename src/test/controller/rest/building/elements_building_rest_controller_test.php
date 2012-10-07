<?php

class ElementsBuildingRestControllerTest extends StandardRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "RoomsBuildingCampsguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new ElementBuildingListModel();
    }

    /**
     * @see StandardRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return ElementsBuildingRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new ElementBuildingModel( $array );
    }

    /**
     * @see StandardRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $modelEdited = ElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Element" );
        $modelEdited->setCoordinates( array ( array ( array ( 500, 600, "L" ), array ( 700, 800, "L" ) ) ) );

        return $modelEdited;
    }

    /**
     * @see StandardRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainerTest()->getelementBuildingDao();
    }

    /**
     * @see StandardRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = ElementBuildingModel::get_( $modelOne );
        $modelTwo = ElementBuildingModel::get_( $modelTwo );

        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Room Building name",
                $testCase );
        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getFloorId(), $modelTwo->getFloorId(),
                "Room Building floor id", $testCase );
        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Room Building coordinates", $testCase );
        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getSectionId(), $modelTwo->getSectionId(),
                "Room Building section", $testCase );
    }

    /**
     * @see StandardRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = ElementBuildingModel::get_( $model );

        ElementBuildingDaoTest::assertNotNullFunction( $model->getId(), "Room Building id", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getFloorId(), "Room Building floor id", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getName(), "Room Building name", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getCoordinates(), "Room Building coordinates",
                $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getSectionId(), "Room Building section id", $testCase );
    }

    /**
     * @see StandardRestControllerTest::createModelTest()
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
        return DaoContainerTest::createElementBuildingTest( $floor->getId(),
                $section->getId() );

    }

    /**
     * @see StandardRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        $model = ElementBuildingModel::get_( $model );
        return $model->getName();
    }

    // /FUNCTIONS


}

?>