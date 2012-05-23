<?php

class ImageResource extends ClassCore
{

    // VARIABLES


    private static $CAMPUSGUIDE, $ICON;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CampusguideImageResource
     */
    public function campusguide()
    {
        self::$CAMPUSGUIDE = self::$CAMPUSGUIDE ? self::$CAMPUSGUIDE : new CampusguideImageResource();
        return self::$CAMPUSGUIDE;
    }

    /**
     * @return IconImageResource
     */
    public function icon()
    {
        self::$ICON = self::$ICON ? self::$ICON : new IconImageResource();
        return self::$ICON;
    }

    // /FUNCTIONS


}

?>