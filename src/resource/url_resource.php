<?php

class UrlResource extends ClassCore
{

    // VARIABLES


    private static $CAMPUSGUIDE;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getUrl( $file, $mode = null, $url = "" )
    {
        return sprintf( "%s?%s%s", $file, $url, $mode ? sprintf("&mode=%s", $mode ) : "" );
    }

    /**
     * @return CampusguideUrlResource
     */
    public function campusguide()
    {
        self::$CAMPUSGUIDE = self::$CAMPUSGUIDE ? self::$CAMPUSGUIDE : new CampusguideUrlResource();
        return self::$CAMPUSGUIDE;
    }

    // /FUNCTIONS


}

?>