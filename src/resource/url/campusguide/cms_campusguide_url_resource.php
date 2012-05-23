<?php

class CmsCampusguideUrlResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $FACILITY;

    private static $FILE = "cms.php";
    private static $FILE_IMAGE = "image.php";

    public static $QUERY_SUCCESS = "success";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    public static function getController( $controller, $mode = null, $url = "" )
    {
        return UrlResource::getUrl( self::$FILE, $mode, sprintf( "/%s%s", $controller, $url ) );
    }

    public static function getImageController( $controller, $id, $width = null, $height = null, $mode = null, $url = "" )
    {
        return UrlResource::getUrl( self::$FILE_IMAGE, $mode, sprintf( "/%s/%s%s%s", $controller, $id, $width && $height ? sprintf( "/%s%s%s", $width, CampusguideImageResource::$SIZE_SPLITTER, $height ) : null, $url ) );
    }

    public static function getPage( $controller, $page, $mode = null, $url = "" )
    {
        return self::getController( $controller, $mode, sprintf( "/%s%s", $page, $url ) );
    }

    public function getSuccessQuery( $message )
    {
        return sprintf( "&%s=%s", urlencode( self::$QUERY_SUCCESS ), $message );
    }

    public function getHome( $mode = null, $url = "" )
    {
        return self::getController( FacilitiesCmsCampusguideMainController::$CONTROLLER_NAME, $mode, $url );
    }

    /**
     * @return BuildingCmsCampusguideUrlResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingCmsCampusguideUrlResource();
        return self::$BUILDING;
    }

    /**
     * @return FacilityCmsCampusguideUrlResource
     */
    public function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityCmsCampusguideUrlResource();
        return self::$FACILITY;
    }

    // /FUNCTIONS


}

?>