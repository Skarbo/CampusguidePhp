<?php

include_once '../KrisSkarboApi/src/util/initialize_util.php';
include_once '../KrisSkarboApi/src/api/simplehtmldom_api.php';
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
//         $this->add( new BuildingsCampusguideRestControllerTest() );
        //$this->add( new FloorsBuildingCampusguideRestControllerTest() );
//         $this->add( new ElementsBuildingCampusguideRestControllerTest() );
        //$this->add( new TypesElementBuildingCampusguideRestControllerTest() );
        //$this->add( new GroupsTypeElementBuildingCampusguideRestControllerTest() );
//         $this->add( new SectionsBuildingCampusguideRestControllerTest() );
        //$this->add( new SearchCampusguideRestControllerTest() );


        //$this->add( new DbbackupHandlerTest() );
//         $this->add(new QueueHandlerTest() );

        //$this->add(new BuildingCampusguideCommandControllerTest());

        $coordinates = "94.9,53.3,L,|273.9,78.3,L,|219.9,177.3,L,|47.9,134.3,L,";
        $coordinates = "94.9,53.3,L,|273.9,78.3,L,|219.9,177.3,Q,310.4%137.0|47.9,134.3,L,";
        $coordinates = "";
        $coordinates = "94.9,53.3,L,|273.9,78.3,L,|219.9,177.3,Q,310.4%137.0|47.9,134.3,L,$336.9,45.3,L,|471.9,22.3,L,|515.9,133.3,L,|353.9,143.3,L,";
        var_dump($coordinates);
        echo "<br />";
        $coordinatesArray = Resource::generateCoordinatesToArray($coordinates);
        var_dump( $coordinatesArray );
        echo "<br />";
        var_dump(Resource::generateCoordinatesToString($coordinatesArray));

    }

}

?>