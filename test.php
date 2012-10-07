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

            //         $this->add( new FacilityDaoTest() );
            //         $this->add( new BuildingDaoTest() );
            //         $this->add( new ElementBuildingDaoTest() );
            //         $this->add( new SectionBuildingDaoTest() );
            //         $this->add( new FloorBuildingDaoTest() );


        //         $this->add( new FloorBuildingHandlerTest() );


//         $this->add( new FacilitiesRestControllerTest() );
//         $this->add( new BuildingsRestControllerTest() );
//         $this->add( new FloorsBuildingRestControllerTest() );
//         $this->add( new ElementsBuildingRestControllerTest() );
//         $this->add( new SectionsBuildingRestControllerTest() );
//         $this->add( new SearchRestControllerTest() );


        //$this->add( new DbbackupHandlerTest() );
        //                 $this->add(new QueueHandlerTest() );


        //$this->add(new BuildingCommandControllerTest());
//         $this->add( new QueueCommandControllerTest() );

        //                 $this->add( new TypesTimeeditScheduleWebsiteParserTest() );
        //         $this->add( new TypesScheduleWebsiteHandlerTest() );
        //         $this->add( new EntriesTimeeditScheduleWebsiteParserTest() );
        // $this->add( new EntriesScheduleWebsiteHandlerTest() );
        //         $this->add(new RoomScheduleDaoTest());


    }

}

?>