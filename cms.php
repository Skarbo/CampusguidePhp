<?php

include_once '../krisskarboapi/src/util/initialize_util.php';
include_once '../krisskarboapi/src/api/api/abstract_api.php';

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

// Initiate CampusguideApi
$campusguide_api = new CampusguideApi( CampusguideApi::MODE_TEST );

// Set Debug handler
$campusguide_api->setDebug(
        array ( CampusguideApi::MODE_TEST => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_DEV => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_PROD => DebugHandler::LEVEL_LOW ) );

// Mapping
$mapping = array ();
$mapping[ FacilitiesCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_CONTROLLER ] = FacilitiesCmsMainController::class_();
$mapping[ FacilitiesCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_VIEW ] = FacilitiesCmsMainView::class_();
$mapping[ BuildingsCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_CONTROLLER ] = BuildingsCmsMainController::class_();
$mapping[ BuildingsCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_VIEW ] = BuildingsCmsMainView::class_();
$mapping[ AdminCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_CONTROLLER ] = AdminCmsMainController::class_();
$mapping[ AdminCmsMainController::$CONTROLLER_NAME ][ AbstractApi::MAP_VIEW ] = AdminCmsMainView::class_();
$mapping[ "" ] = $mapping[ FacilitiesCmsMainController::$CONTROLLER_NAME ];

// Create KillHandler
class ApirestKillHandler extends ClassCore implements KillHandler
{

    private static $FIELD_ERROR = "error";
    private static $FIELD_ERROR_MESSAGE = "message";
    private static $FIELD_ERROR_EXCEPTION = "exception";
    private static $FIELD_ERROR_VALIDATIONS = "validations";

    /**
     * @see KillHandler::handle()
     */
    public function handle( Exception $exception, ErrorHandler $error_handler )
    {

        // Exception type
        switch ( get_class( $exception ) )
        {

            default :
                header( "HTTP/1.1 500 Internal Server Error" );
                break;
        }

        // Print content
        die( "Kill Handler: " . $exception->getMessage() );

    }

    /**
     * @see KillHandler::isAutoErrorLog()
     */
    public function isAutoErrorLog( Exception $exception )
    {
        return true;
    }

}

// Create OutputHandler
class MainOutputHandler extends OutputHandler
{

    /**
     * @see OutputHandler::handle()
     */
    public function handle( AbstractXhtml $output )
    {

        @header( "Content-Type: text/html; charset= UTF-8" );
        $doctype = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
        //$doctype = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";


        return $doctype . $output;

    }

}

// Set Kill handler
$campusguide_api->setKillHandler( new ApirestKillHandler() );

// Set Output handler
$campusguide_api->setOutputHandler( new MainOutputHandler() );

// Do request
$campusguide_api->doRequest( $mapping );

$campusguide_api->destruct();

?>