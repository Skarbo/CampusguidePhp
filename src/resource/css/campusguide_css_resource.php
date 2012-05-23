<?php

class CampusguideCssResource extends ClassCore
{

    // VARIABLES


    private static $APP, $CMS;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return AppCampusguideCssResource
     */
    public function app()
    {
        self::$APP = self::$APP ? self::$APP : new AppCampusguideCssResource();
        return self::$APP;
    }

    /**
     * @return CmsCampusguideCssResource
     */
    public function cms()
    {
        self::$CMS = self::$CMS ? self::$CMS : new CmsCampusguideCssResource();
        return self::$CMS;
    }

    // /FUNCTIONS


}

?>