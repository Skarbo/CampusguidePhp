<?php

class CampusguideUrlResource extends ClassCore
{

    // VARIABLES


    private static $APP, $CMS;
    private $googleDirections = "http://maps.google.com/maps?saddr=%s&daddr=%s";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    /**
     * @return AppCampusguideUrlResource
     */
    public function app()
    {
        self::$APP = self::$APP ? self::$APP : new AppCampusguideUrlResource();
        return self::$APP;
    }

    /**
     * @return CmsCampusguideUrlResource
     */
    public function cms()
    {
        self::$CMS = self::$CMS ? self::$CMS : new CmsCampusguideUrlResource();
        return self::$CMS;
    }

    // /FUNCTIONS


    public function getGoogleDirections()
    {
        return $this->googleDirections;
    }

}

?>