<?php

include_once '../krisskarboapi/src/util/initialize_util.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        @header( "HTTP/1.1 500 Internal Server Error" );
    }
}

$QUERY_SVG = "svg";
$QUERY_COLOR = "color";
$QUERY_HEIGHT = "height";
$QUERY_WIDTH = "width";

$REGEX_FILE = '/[^a-zA-Z0-9\_]/i';
$REGEX_SVG_COLOR = '/(fill|stroke):(.*?)(;|")/';
$REGEX_SVG_COLOR_REPLACE = '${1}:%s${3}';
$REGEX_SVG_WIDTH = '/<svg(.*?)width="(\d+)"(.*?)>/s';
$REGEX_SVG_HEIGHT = '/<svg(.*?)height="(\d+)"(.*?)>/s';
$REGEX_SVG_WIDTH_REPLACE = "<svg\n\${1}width=\"%s\"\${3}\n>";
$REGEX_SVG_HEIGHT_REPLACE = "<svg\n\${1}height=\"%s\"\${3}\n>";

$svgFolder = sprintf( preg_replace( '/\./i', DIRECTORY_SEPARATOR, "%s.image.icon.svg" ), __DIR__ );
$handle = @opendir( $svgFolder );

$svgFile = preg_replace( $REGEX_FILE, "", Core::arrayAt( $_GET, $QUERY_SVG, "" ) );
$svgColor = Core::arrayAt( $_GET, $QUERY_COLOR );
$svgHeight = intval( Core::arrayAt( $_GET, $QUERY_HEIGHT ) );
$svgWidth = intval( Core::arrayAt( $_GET, $QUERY_WIDTH ) );

if ( $handle )
{
    $ignore = array ( ".", "..", ".git" );
    while ( false !== ( $entry = readdir( $handle ) ) )
    {
        if ( in_array( $entry, $ignore ) )
            continue;
        if ( basename( $entry, ".svg" ) == $svgFile )
        {
            closedir( $handle );
            @header( "Content-type: image/svg+xml" );

            $entryPath = sprintf( "%s%s%s", $svgFolder, DIRECTORY_SEPARATOR, $entry );
            $contents = file_get_contents( $entryPath );
            $lastModified = filemtime( $entryPath );
            $modifiedSince = AbstractController::getIfModifiedSinceHeader();

            if ( $lastModified )
                @header( sprintf( "Last-Modified: %s GMT", gmdate( "D, d M Y H:i:s", $lastModified ) ) );

            if ( $lastModified <= $modifiedSince )
            {
                @header( "HTTP/1.1 304 Not Modified" );
                exit();
            }

            if ( $svgColor )
                $contents = preg_replace( $REGEX_SVG_COLOR, sprintf( $REGEX_SVG_COLOR_REPLACE, $svgColor ), $contents );
            if ( $svgHeight )
                $contents = preg_replace( $REGEX_SVG_HEIGHT, sprintf( $REGEX_SVG_HEIGHT_REPLACE, $svgHeight ),
                        $contents );
            if ( $svgWidth )
                $contents = preg_replace( $REGEX_SVG_WIDTH, sprintf( $REGEX_SVG_WIDTH_REPLACE, $svgWidth ), $contents );

            echo $contents;

            exit();
            break;
        }
    }
    closedir( $handle );
}

@header( "HTTP/1.1 400 Bad Request" );

?>