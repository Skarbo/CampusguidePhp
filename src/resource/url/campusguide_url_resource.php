<?php

class CampusguideUrlResource extends ClassCore
{

    // VARIABLES


    private static $CMS;
    private $googleDirections = "http://maps.google.com/maps?saddr=%s&daddr=%s";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


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