<?php

include_once '../../krisskarboapi/javascript/javascript.js.php';
$JAVASCRIPT_FILES = array();

// Javascript files
$restrict = array( "ignore" => array( "folders" => array ('^app$', '^api$' ), "files" => array( '\.php$' )),
        "include" => array( "files" => array( 'canvas', 'buildingcreator' ) ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( ".", $restrict ) );

// Javascript generate
FileUtil::generateFiles( $JAVASCRIPT_FILES, __FILE__, FileUtil::TYPE_JAVASCRIPT );

?>