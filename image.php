<?php

include_once '../krisskarboapi/src/util/initialize_util.php';
include_once '../krisskarboapi/src/api/api.php';

function __autoload( $class_name )
{
    try
    {
        $class_path = InitializeUtil::getClassPathFile( $class_name, dirname( __FILE__ ) );
        require_once ( $class_path );
    }
    catch ( Exception $e )
    {
        throw $e;
    }
}

// Generate mode
$mode = isset( $_GET[ "mode" ] ) && in_array( $_GET[ "mode" ], CampusguideApi::$MODES ) ? $_GET[ "mode" ] : CampusguideApi::MODE_TEST;

// Initiate CampusguideApi
$campusguide_api = new CampusguideApi( $mode );

// Set Debug handler
$campusguide_api->setDebug(
        array ( CampusguideApi::MODE_TEST => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_DEV => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_PROD => DebugHandler::LEVEL_HIGH ) );

// Mapping
$mapping = array ();
$mapping[ FacilityCmsCampusguideImageController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = FacilityCmsCampusguideImageController::class_();
$mapping[ FacilityCmsCampusguideImageController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = FacilityCmsCampusguideImageView::class_();
$mapping[ BuildingCmsCampusguideImageController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingCmsCampusguideImageController::class_();
$mapping[ BuildingCmsCampusguideImageController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = BuildingCmsCampusguideImageView::class_();
$mapping[ "" ] = $mapping[ FacilityCmsCampusguideImageController::$CONTROLLER_NAME ];

// Create KillHandler
class ImageKillHandler extends ClassCore implements KillHandler
{

    /**
     * @param string font    */
    private function generateImage( $text )
    {
        $font = 5;
        $textwidth = imagefontwidth( $font ) * strlen( $text );
        $textheight = imagefontheight( $font );

        // Create image
        $im = imagecreate( $textwidth, $textheight );

        // White background and blue text
        $bg = imagecolorallocate( $im, 255, 255, 255 );
        $textcolor = imagecolorallocate( $im, 0, 0, 255 );

        // Write the string at the top left
        imagestring( $im, $font, 0, 0, $text, $textcolor );

        // Output the image
        header( 'Content-type: image/png' );

        imagepng( $im );
        imagedestroy( $im );
    }

    /**
     * @see KillHandler::handle()
     */
    public function handle( Exception $exception, ErrorHandler $error_handler )
    {

        // Exception type
        switch ( get_class( $exception ) )
        {

            case BadrequestException::class_() :
                @header( "HTTP/1.1 400 Bad Request" );
                break;

            default :
                @header( "HTTP/1.1 500 Internal Server Error" );
                break;
        }

        // Generate image
        $this->generateImage( $exception->getMessage() );

        die();

    }

    /**
     * @see KillHandler::isAutoErrorLog()
     */
    public function isAutoErrorLog( Exception $exception )
    {
        switch ( get_class( $exception ) )
        {

            case BadrequestException::class_() :
                return false;

            default :
                return true;
        }
    }

}

// Create OutputHandler
class ImageOutputHandler extends OutputHandler
{

    /**
     * @see OutputHandler::handle()
     */
    public function handle( AbstractXhtml $output )
    {

        if ( $output == null )
        {
            return "";
        }

        return $output->get_content();

    }

}

// Set Kill handler
$campusguide_api->setKillHandler( new ImageKillHandler() );

// Set Output handler
$campusguide_api->setOutputHandler( new ImageOutputHandler() );

// Do request
$campusguide_api->doRequest( $mapping );

$campusguide_api->destruct();

?>