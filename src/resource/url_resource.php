<?php

class UrlResource extends ClassCore
{

    // VARIABLES


    private static $APP, $CMS;
    private $googleDirections = "http://maps.google.com/maps?saddr=%s&daddr=%s";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getUrl( $file, $mode = null, $url = "" )
    {
        return sprintf( "%s?%s%s", $file, $url, $mode ? sprintf( "&mode=%s", $mode ) : "" );
    }

    /**
     * @return AppUrlResource
     */
    public function app()
    {
        self::$APP = self::$APP ? self::$APP : new AppUrlResource();
        return self::$APP;
    }

    /**
     * @return CmsUrlResource
     */
    public function cms()
    {
        self::$CMS = self::$CMS ? self::$CMS : new CmsUrlResource();
        return self::$CMS;
    }

    public function getGoogleDirections()
    {
        return $this->googleDirections;
    }

    // /FUNCTIONS


}

?>