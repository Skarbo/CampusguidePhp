<?php

class GroupTypeElementBuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "GroupTypeElementBuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->groupTypeElementBuildingDao;
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = GroupTypeElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Group Type Element Building" );

        return $modelEdited;

    }

    /**
     * @see StandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        return self::createGroupTypeElementBuildingTest();
    }

    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = GroupTypeElementBuildingModel::get_( $modelOne );
        $modelTwo = GroupTypeElementBuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Group Type Element Building name",
                $this );

    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = GroupTypeElementBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Group Type Element Building id", $this );
        self::assertNotNullFunction( $model->getName(), "Group Type Element Building name", $this );

    }

    public function testShouldGetForeign()
    {
        // Unsupported method
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