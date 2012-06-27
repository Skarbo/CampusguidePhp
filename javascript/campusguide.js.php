<?php

include_once '../../krisskarboapi/javascript/javascript.js.php';

// Javascript files
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "event" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "core" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "controller" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "view" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "dao" ) );
$JAVASCRIPT_FILES = array_merge( $JAVASCRIPT_FILES, Core::getDirectory( "handler" ) );

// Javascript generate
FileUtil::generateFiles( $JAVASCRIPT_FILES, __FILE__, FileUtil::TYPE_JAVASCRIPT );

?>