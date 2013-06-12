<?php

include_once '../../krisskarboapi/css/css.css.php';

// Css files
$restrict = array ( "ignore" => array ( "folders" => array ( '^app$', '^images$' ) ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "view", $restrict ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "gui", $restrict ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "jqueryui", $restrict ) );

// Css generate
FileUtil::generateFiles( $CSS_FILES, __FILE__, FileUtil::TYPE_CSS );

?>