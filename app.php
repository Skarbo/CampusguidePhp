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
                CampusguideApi::MODE_PROD => DebugHandler::LEVEL_HIGH ) );

// Mapping
$mapping = array ();
$mapping[ MapAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = MapAppMainController::class_();
$mapping[ MapAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = MapAppMainView::class_();
$mapping[ BuildingAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingAppMainController::class_();
$mapping[ BuildingAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = BuildingAppMainView::class_();
$mapping[ ElementBuildingAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = ElementBuildingAppMainController::class_();
$mapping[ ElementBuildingAppMainController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = ElementBuildingAppMainView::class_();
$mapping[ "" ] = $mapping[ MapAppMainController::$CONTROLLER_NAME ];

// Create KillHandler
class AppKillHandler extends ClassCore implements KillHandler
{

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

        die( sprintf( "Kill handler: %s", $exception->getMessage() ) );

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
class AppOutputHandler extends OutputHandler
{

    /**
     * @see OutputHandler::handle()
     */
    public function handle( AbstractXhtml $output )
    {

        @header( "Content-Type: text/html; charset= UTF-8" );
        //$doctype = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">\n";
        //$doctype = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n";
        $doctype = "<!DOCTYPE html>";

        return $doctype . $output;

    }

}

// Set Kill handler
$campusguide_api->setKillHandler( new AppKillHandler() );

// Set Output handler
$campusguide_api->setOutputHandler( new AppOutputHandler() );

// Do request
$campusguide_api->doRequest( $mapping );

$campusguide_api->destruct();

?>