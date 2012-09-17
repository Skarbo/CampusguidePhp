<?php

include_once '../../KrisSkarboApi/css/css.css.php';

// Css files
$restrict = array( "ignore" => array( "folders" => array( '^app$' ) ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "view", $restrict ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "gui", $restrict ) );

// Css generate
FileUtil::generateFiles( $CSS_FILES, __FILE__, FileUtil::TYPE_CSS );

?>