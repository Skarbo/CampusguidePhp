<?php

include_once '../KrisSkarboApi/generator.php';

$generator = new Generator( "localhost", "root", "", "campusguide_test", Generator::MODE_DAO_DB );
// // $generator->skipTables = array ( "building", "building_element", "building_element_type", "building_element_type_group",
// //         "building_floor", "building_section", "building_debug", "debug", "error", "facility", "queue",
// //         "schedule_entry_faculty", "schedule_entry_group" );
$generator->onlyTables = array( "log" );
$generator->doGenerate( realpath( "./" ) );

?>