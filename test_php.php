<?php

include '../KrisSkarboApi/src/core/core.php';

$array1 = array( "test" => array( "key" => array() ) );
$array2 = array( "test" => array( "key" => "test5" ) );

var_dump( array_merge($array1, $array2) );

?>