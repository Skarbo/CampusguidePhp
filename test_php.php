<?php

include '../KrisSkarboApi/src/core/core.php';

// Create a curl handle
$ch = curl_init( 'http://timeedit.hib.no/4DACTION/WebShowSearch/1/2-0' );

// Execute
curl_exec( $ch );

// Check if any error occured
if ( !curl_errno( $ch ) )
{
    $info = curl_getinfo( $ch );
    var_dump( $info );
}

// Close handle
curl_close( $ch );

?>