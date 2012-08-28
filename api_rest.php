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

// Initiate CampusguideApi
$campusguide_api = new CampusguideApi( CampusguideApi::MODE_TEST );

// Set Debug handler
$campusguide_api->setDebug(
        array ( CampusguideApi::MODE_TEST => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_DEV => DebugHandler::LEVEL_LOW,
                CampusguideApi::MODE_PROD => DebugHandler::LEVEL_HIGH ) );

// Mapping
$mapping = array ();
$mapping[ FacilitiesCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = FacilitiesCampusguideRestController::class_();
$mapping[ FacilitiesCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = FacilitiesCampusguideRestView::class_();
$mapping[ BuildingsCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = BuildingsCampusguideRestController::class_();
$mapping[ BuildingsCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = BuildingsCampusguideRestView::class_();
$mapping[ FloorsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = FloorsBuildingCampusguideRestController::class_();
$mapping[ FloorsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = FloorsBuildingCampusguideRestView::class_();
$mapping[ ElementsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = ElementsBuildingCampusguideRestController::class_();
$mapping[ ElementsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = ElementsBuildingCampusguideRestView::class_();
$mapping[ TypesElementBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = TypesElementBuildingCampusguideRestController::class_();
$mapping[ TypesElementBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = TypesElementBuildingCampusguideRestView::class_();
$mapping[ GroupsTypeElementBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = GroupsTypeElementBuildingCampusguideRestController::class_();
$mapping[ GroupsTypeElementBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = GroupsTypeElementBuildingCampusguideRestView::class_();
$mapping[ SectionsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = SectionsBuildingCampusguideRestController::class_();
$mapping[ SectionsBuildingCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = SectionsBuildingCampusguideRestView::class_();

$mapping[ SearchCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_CONTROLLER ] = SearchCampusguideRestController::class_();
$mapping[ SearchCampusguideRestController::$CONTROLLER_NAME ][ CampusguideApi::MAP_VIEW ] = SearchCampusguideRestView::class_();

$mapping[ "" ] = $mapping[ FacilitiesCampusguideRestController::$CONTROLLER_NAME ];

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
        $json = RestView::getJSON( $data );

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