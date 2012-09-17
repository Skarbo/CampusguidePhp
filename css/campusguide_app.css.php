<?php

include_once '../../krisskarboapi/css/css.css.php';

// Css files
$restrict = array( "ignore" => array( "folders" => array( '^cms$' ) ) );
$CSS_FILES = array_merge( $CSS_FILES, Core::getDirectory( "view", $restrict ) );

// Css generate
FileUtil::generateFiles( $CSS_FILES, __FILE__, FileUtil::TYPE_CSS );

?>