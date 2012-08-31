<?php

include_once '../../KrisSkarboApi/css/css.css.php';

// Css files
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "view", array( "app" ) ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "gui", array( "app" ) ) );

// Css generate
FileUtil::generateFiles( $CSS_FILES, __FILE__, FileUtil::TYPE_CSS );

?>