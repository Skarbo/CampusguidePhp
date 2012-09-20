<?php

abstract class CampusguideCommandController extends CommandController implements CampusguideInterfaceController
{

    // VARIABLES


    const URI_COMMAND = 1;
    const URI_ID = 2;

    public static $ID_SPLITTER = "_";

    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setCampusguideHandler( new CampusguideHandler( $this->getDbApi() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @see CampusguideInterfaceController::getCampusguideHandler()
     */
    public function getCampusguideHandler()
    {
        return $this->campusguideHandler;
    }

    /**
 * @param CampusguideHandler $campusguideHandler
 */
    private function setCampusguideHandler( CampusguideHandler $campusguideHandler )
    {
        $this->campusguideHandler = $campusguideHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return int Id given in URI, null if none given
     */
    protected static function getId()
    {
        return Core::arrayAt( self::getIds(), 0, null );
    }

    /**
     * @return int Id's given in URI
     */
    protected static function getIds()
    {
        return array_filter(
                array_map(
                        function ( $val )
                        {
                            return intval( $val );
                        }, explode( self::$ID_SPLITTER, self::getURI( self::URI_ID ) ) ) );
    }

    /**
     * @return string URI command
     */
    protected static function getCommand()
    {
        return self::getURI( self::URI_COMMAND );
    }

    // ... ... /STATIC


    // ... /GET


    // /FUNCTIONS


}