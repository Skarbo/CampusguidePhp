<?php

include_once '../../krisskarboapi/javascript/javascript.js.php';

// Javascript files
$restrict = array( "cms" );
$restrict = array( "ignore" => array( "folders" => array ('^cms$', '^api$' ), "files" => array( '\.php$' )) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( ".", $restrict ) );

// Javascript generate
FileUtil::generateFiles( $JAVASCRIPT_FILES, __FILE__, FileUtil::TYPE_JAVASCRIPT );

?>