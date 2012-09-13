<?php

class ElementsBuildingCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
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
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new ElementBuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return ElementsBuildingCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new ElementBuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $modelEdited = ElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Element" );
        $modelEdited->setCoordinates( array ( array ( array ( 500, 600, "L" ), array ( 700, 800, "L" ) ) ) );

        return $modelEdited;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->elementBuildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
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
        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getTypeId(), $modelTwo->getTypeId(),
                "Room Building element type id", $testCase );
        ElementBuildingDaoTest::assertEqualsFunction( $modelOne->getSectionId(), $modelTwo->getSectionId(),
                "Room Building section", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = ElementBuildingModel::get_( $model );

        ElementBuildingDaoTest::assertNotNullFunction( $model->getId(), "Room Building id", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getFloorId(), "Room Building floor id", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getName(), "Room Building name", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getCoordinates(), "Room Building coordinates",
                $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getTypeId(), "Room Building element type id", $testCase );
        ElementBuildingDaoTest::assertNotNullFunction( $model->getSectionId(), "Room Building section id", $testCase );
    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
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
        return ElementBuildingDaoTest::createElementBuildingTest( $floor->getId(), $elementType->getId(),
                $section->getId() );

    }

    /**
     * @see StandardCampusguideRestControllerTest::getSearchString()
     */
    protected function getSearchString( StandardModel $model )
    {
        $model = ElementBuildingModel::get_( $model );
        return $model->getName();
    }

    // /FUNCTIONS


}

?>