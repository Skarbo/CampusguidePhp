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
$mapping[ FacilitiesRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = FacilitiesRestController::class_();
$mapping[ FacilitiesRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = FacilitiesRestView::class_();
$mapping[ BuildingsRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingsRestController::class_();
$mapping[ BuildingsRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = BuildingsRestView::class_();
$mapping[ FloorsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = FloorsBuildingRestController::class_();
$mapping[ FloorsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = FloorsBuildingRestView::class_();
$mapping[ ElementsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = ElementsBuildingRestController::class_();
$mapping[ ElementsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = ElementsBuildingRestView::class_();
$mapping[ SectionsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = SectionsBuildingRestController::class_();
$mapping[ SectionsBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = SectionsBuildingRestView::class_();
$mapping[ NavigationBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = NavigationBuildingRestController::class_();
$mapping[ NavigationBuildingRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = NavigationBuildingRestView::class_();

$mapping[ SearchRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = SearchRestController::class_();
$mapping[ SearchRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = SearchRestView::class_();
$mapping[ NavigateRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = NavigateRestController::class_();
$mapping[ NavigateRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = NavigateRestView::class_();
$mapping[ BuildingcreatorRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingcreatorRestController::class_();
$mapping[ BuildingcreatorRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = BuildingcreatorRestView::class_();

$mapping[ "" ] = $mapping[ FacilitiesRestController::$CONTROLLER_NAME ];

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

        // Initiate data array
        $data = array ();

        // Set exception
        $data[ self::$FIELD_ERROR ][ self::$FIELD_ERROR_MESSAGE ] = $exception->getMessage();
        $data[ self::$FIELD_ERROR ][ self::$FIELD_ERROR_EXCEPTION ] = get_class( $exception );

        // Exception type
        switch ( get_class( $exception ) )
        {
            case DbException::class_() :
                @header( "HTTP/1.1 500 Internal Server Error" );
                $data[ self::$FIELD_ERROR ][ self::$FIELD_ERROR_MESSAGE ] = "Database error";
                break;

            case BadrequestException::class_() :
                @header( "HTTP/1.1 400 Bad Request" );
                break;

            case ValidatorException::class_() :
                @header( "HTTP/1.1 406 Not Acceptable" );
                $data[ self::$FIELD_ERROR ][ self::$FIELD_ERROR_VALIDATIONS ] = ValidatorException::get_( $exception )->getValidations();
                break;

            default :
                @header( "HTTP/1.1 500 Internal Server Error" );
                break;
        }

        // Set Javascript as Content type
        @header( sprintf( "Content-type: %s;charset=%s", "application/json", "utf-8" ) );

        // Get JSON from data
        $json = AbstractRestView::getJSON( $data );

        die( $json );

    }

    /**
     * @see KillHandler::isAutoErrorLog()
     */
    public function isAutoErrorLog(Exception $exception)
    {
        return true;
    }

}

// Create OutputHandler
class ApirestOutputHandler extends OutputHandler
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
$campusguide_api->setKillHandler( new ApirestKillHandler() );

// Set Output handler
$campusguide_api->setOutputHandler( new ApirestOutputHandler() );

// Do request
$campusguide_api->doRequest(  $mapping );

// Destruct
$campusguide_api->destruct();

?>