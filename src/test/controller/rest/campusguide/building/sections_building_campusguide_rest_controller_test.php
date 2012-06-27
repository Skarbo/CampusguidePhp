<?php

class SectionsBuildingCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "SectionsBuildingCampsguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new SectionBuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return SectionsBuildingCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new SectionBuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = SectionBuildingModel::get_( $model );

        $modelEdited->setName( "Edited Section" );
        $modelEdited->setCoordinates( array ( array ( 500, 600 ), array ( 700, 800 ) ) );

        return $modelEdited;

    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->sectionBuildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = FloorBuildingModel::get_( $modelOne );
        $modelTwo = FloorBuildingModel::get_( $modelTwo );

        SectionBuildingDaoTest::assertEqualsFunction( $modelOne->getBuildingId(), $modelTwo->getBuildingId(),
                "Section Building id", $testCase );
        SectionBuildingDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(),
                "Section Building name", $testCase );
        SectionBuildingDaoTest::assertEqualsFunction( $modelOne->getCoordinates(), $modelTwo->getCoordinates(),
                "Section Building coordinates", $testCase );

    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = FloorBuildingModel::get_( $model );

        SectionBuildingDaoTest::assertNotNullFunction( $model->getId(), "Section Building id", $testCase );
        SectionBuildingDaoTest::assertNotNullFunction( $model->getBuildingId(), "Section Building building id",
                $testCase );
        SectionBuildingDaoTest::assertNotNullFunction( $model->getName(), "Section Building name", $testCase );
        SectionBuildingDaoTest::assertNotNullFunction( $model->getCoordinates(), "Section Building coordinates",
                $testCase );

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

        // Create Sections
        return SectionBuildingDaoTest::createSectionBuildingTest( $building->getId() );

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