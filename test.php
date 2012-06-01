<?php

include_once '../KrisSkarboApi/src/util/initialize_util.php';
include_once '../KrisSkarboApi/src/api/simplehtmldom/simple_html_dom.php';
include_once '../SimpleTest/simpletest/autorun.php';
include_once '../SimpleTest/simpletest/web_tester.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        throw $e;
    }
}

class AllTests extends TestSuite
{

    public function __construct()
    {

        parent::TestSuite( "All tests" );

        //$this->add( new FacilityDaoTest() );
//         $this->add( new BuildingDaoTest() );
        //$this->add( new ElementBuildingDaoTest() );
        //$this->add( new TypeElementBuildingDaoTest() );
        //$this->add( new GroupTypeElementBuildingDaoTest() );
        //$this->add( new SectionBuildingDaoTest() );
        //$this->add( new FloorBuildingDaoTest() );


        //         $this->add( new FloorBuildingHandlerTest() );


        //$this->add( new FacilitiesCampusguideRestControllerTest() );
        $this->add( new BuildingsCampusguideRestControllerTest() );
        //$this->add( new FloorsBuildingCampusguideRestControllerTest() );
//         $this->add( new ElementsBuildingCampusguideRestControllerTest() );
        //$this->add( new TypesElementBuildingCampusguideRestControllerTest() );
        //$this->add( new GroupsTypeElementBuildingCampusguideRestControllerTest() );
//         $this->add( new SectionsBuildingCampusguideRestControllerTest() );


        //$this->add( new DbbackupHandlerTest() );
//         $this->add(new QueueHandlerTest() );

        //$this->add(new BuildingCampusguideCommandControllerTest());


    }

}

?>