<?php

class AppCampusguideUrlResource extends ClassCore
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
     * @return BuildingAppCampusguideUrlResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingAppCampusguideUrlResource();
        return self::$BUILDING;
    }

    // /FUNCTIONS


}

?>