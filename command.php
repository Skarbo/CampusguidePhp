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
$mapping[ BuildingCampusguideCommandController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingCampusguideCommandController::class_();
$mapping[ BuildingCampusguideCommandController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = CommandView::class_();

// Create KillHandler
class CommandKillHandler extends ClassCore implements KillHandler
{

    /**
     * @see KillHandler::handle()
     */
    public function handle( Exception $exception, ErrorHandler $error_handler )
    {

        // Produce status code
        $status_code = 0;
        switch ( get_class( $exception ) )
        {

            case BadrequestException::class_() :
                $status_code = Controller::STATUS_BAD_REQUEST;
                break;

            default :
                $status_code = Controller::STATUS_SERVER_ERROR;
                break;

        }

        // Set header
        @header( sprintf( "HTTP/1.0 %d", $status_code ) );

        exit();

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
class CommandOutputHandler extends OutputHandler
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
$campusguide_api->setKillHandler( new CommandKillHandler() );

// Set Output handler
$campusguide_api->setOutputHandler( new CommandOutputHandler() );

// Do request
$campusguide_api->doRequest( new DoublearrayCore( $mapping ) );

// Destruct
$campusguide_api->destruct();

?>