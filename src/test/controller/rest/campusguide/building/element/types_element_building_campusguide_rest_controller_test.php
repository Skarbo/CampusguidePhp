<?php

class TypesElementBuildingCampusguideRestControllerTest extends StandardCampusguideRestControllerTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypesElementBuildingCampusguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardCampusguideRestControllerTest::getInitiatedModelList()
     */
    protected function getInitiatedModelList()
    {
        return new TypeElementBuildingListModel();
    }

    /**
     * @see StandardCampusguideRestControllerTest::getControllerName()
     */
    protected function getControllerName()
    {
        return TypesElementBuildingCampusguideRestController::$CONTROLLER_NAME;
    }

    /**
     * @see StandardCampusguideRestControllerTest::getRestModel()
     */
    protected function getRestModel( array $array )
    {
        return new TypeElementBuildingModel( $array );
    }

    /**
     * @see StandardCampusguideRestControllerTest::getEditedModel()
     */
    protected function getEditedModel( StandardModel $model )
    {

        $modelEdited = TypeElementBuildingModel::get_( $model );

        $modelEdited->setName( "Updated Element Type" );
        $modelEdited->setIcon( "updatedicon" );

        return $modelEdited;

    }

    /**
     * @see StandardCampusguideRestControllerTest::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->typeElementBuildingDao;
    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelEquals()
     */
    protected function assertModelEquals( Model $modelOne, Model $modelTwo, SimpleTestCase $testCase )
    {

        $modelOne = TypeElementBuildingModel::get_( $modelOne );
        $modelTwo = TypeElementBuildingModel::get_( $modelTwo );

        TypeElementBuildingDaoTest::assertEqualsFunction( $modelOne->getName(), $modelTwo->getName(),
                "Type Element Building name", $testCase );
        TypeElementBuildingDaoTest::assertEqualsFunction( $modelOne->getGroupId(), $modelTwo->getGroupId(),
                "Type Element Building group id", $testCase );
        TypeElementBuildingDaoTest::assertEqualsFunction( $modelOne->getIcon(), $modelTwo->getIcon(),
                "Type Element Building icon", $testCase );

    }

    /**
     * @see StandardCampusguideRestControllerTest::assertModelNotNull()
     */
    protected function assertModelNotNull( Model $model, SimpleTestCase $testCase )
    {

        $model = TypeElementBuildingModel::get_( $model );

        TypeElementBuildingDaoTest::assertNotNullFunction( $model->getIdURI(), "Type Element Building id", $testCase );
        TypeElementBuildingDaoTest::assertNotNullFunction( $model->getName(), "Type Element Building name", $testCase );
        TypeElementBuildingDaoTest::assertNotNullFunction( $model->getGroupId(), "Type Element Building group id",
                $testCase );
        TypeElementBuildingDaoTest::assertNotNullFunction( $model->getIcon(), "Type Element Building icon", $testCase );

    }

    /**
     * @see StandardCampusguideRestControllerTest::createModelTest()
     */
    protected function createModelTest()
    {

        // Add Element Type Group
        $elementTypeGroup = $this->addGroupTypeElement();

        // Create Element
        return TypeElementBuildingDaoTest::createTypeElementBuildingTest( $elementTypeGroup->getId() );

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