<?php

class TypeElementBuildingDaoTest extends StandardDaoTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypeElementBuildingDao Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardDaoTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->typeElementBuildingDao;
    }

    /**
     * @see StandardDaoTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {
        $modelEdited = TypeElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Element" );
        $modelEdited->setIcon( "updatedIcon" );

        return $model;
    }

    /**
     * @see StandardDaoTest::createModelTest()
     */
    protected function createModelTest()
    {
        $groupTypeElement = $this->addGroupTypeElement();

        return self::createTypeElementBuildingTest( $groupTypeElement->getId() );
    }

    /**
     * @see StandardDaoTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {
        $modelOne = TypeElementBuildingModel::get_( $modelOne );
        $modelTwo = TypeElementBuildingModel::get_( $modelTwo );

        self::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(), "Type Element Building name",
                $testCase );
        self::assertEqualsFunction( $modelOne->getGroupId(), $modelTwo->getGroupId(), "Type Element Building group id",
                $testCase );
        self::assertEqualsFunction( $modelOne->getIcon(), $modelTwo->getIcon(), "Type Element Building icon",
                $testCase );
    }

    /**
     * @see StandardDaoTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {
        $model = TypeElementBuildingModel::get_( $model );

        self::assertNotNullFunction( $model->getId(), "Type Element Building id", $testCase );
        self::assertNotNullFunction( $model->getName(), "Type Element Building name", $testCase );
        self::assertNotNullFunction( $model->getGroupId(), "Type Element Building group id", $testCase );
        self::assertNotNullFunction( $model->getIcon(), "Type Element Building icon", $testCase );
    }

    // /FUNCTIONS


}

?>