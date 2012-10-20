<?php

class AppUrlResource extends ClassCore
{

    // VARIABLES


    private static $FILE = "app.php";
    private static $BUILDING;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getController( $controller, $mode = null, $url = "" )
    {
        return UrlResource::getUrl( self::$FILE, $mode, sprintf( "/%s%s", $controller, $url ) );
    }

    /**
     * @return BuildingAppUrlResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingAppUrlResource();
        return self::$BUILDING;
    }

    public function getMap( $mode, $url = "" )
    {
        return self::getController( MapAppMainController::$CONTROLLER_NAME, $mode, $url );
    }

    // /FUNCTIONS


}

?>