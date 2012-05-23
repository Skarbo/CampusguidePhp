<?php

include '../KrisSkarboApi/src/core/core.php';

$array = array(  );
$arrays = array( array( 100, 200 ), array( 100, 300 ) );
$result = array_filter($arrays, function($var) use($array) { return $var == $array; });


var_dump($result, !empty( $result ));

?>