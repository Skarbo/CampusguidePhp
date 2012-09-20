<?php

class GroupsTypeElementBuildingCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "GroupsTypeElementBuildingCampusguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new GroupTypeElementBuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return GroupsTypeElementBuildingCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new GroupTypeElementBuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = GroupTypeElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Element Type Group" );

        return $modelEdited;

    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->groupTypeElementBuildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = GroupTypeElementBuildingModel::get_( $modelOne );
        $modelTwo = GroupTypeElementBuildingModel::get_( $modelTwo );

        GroupTypeElementBuildingDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(),
                "Group Type Element Building name", $testCase );

    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = GroupTypeElementBuildingModel::get_( $model );

        GroupTypeElementBuildingDaoTest::assertNotNullFunction( $model->getIdURI(), "Group Type Element Building id",
                $testCase );
        GroupTypeElementBuildingDaoTest::assertNotNullFunction( $model->getName(), "Group Type Element Building name",
                $testCase );

    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {
        return GroupTypeElementBuildingDaoTest::createGroupTypeElementBuildingTest();
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