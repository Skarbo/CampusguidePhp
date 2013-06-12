<?php

class CmsUrlResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $FACILITY, $ADMIN;

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

    public static function getImageController( $controller, $id, $type, $width = null, $height = null, $mode = null, $url = "" )
    {
        return UrlResource::getUrl( self::$FILE_IMAGE, $mode, sprintf( "/%s/%s/%s%s%s", $controller, $id, $type, $width && $height ? sprintf( "/%s%s%s", $width, ImageResource::$SIZE_SPLITTER, $height ) : null, $url ) );
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
        return self::getController( FacilitiesCmsMainController::$CONTROLLER_NAME, $mode, $url );
    }

    /**
     * @return BuildingsCmsUrlResource
     */
    public function buildings()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingsCmsUrlResource();
        return self::$BUILDING;
    }

    /**
     * @return FacilityCmsUrlResource
     */
    public function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityCmsUrlResource();
        return self::$FACILITY;
    }

    /**
     * @return AdminCmsUrlResource
     */
    public function admin()
    {
        self::$ADMIN = self::$ADMIN ? self::$ADMIN : new AdminCmsUrlResource();
        return self::$ADMIN;
    }

    // /FUNCTIONS


}

?>