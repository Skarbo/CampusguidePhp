<?php

class CssResource extends AbstractCssResource
{

    // VARIABLES


    private static $CAMPUSGUIDE;

    private static $CSS_ROOT = "css";

    private $cssFile = "campusguide.css.php";
    private $cssAppFile = "campusguide_app.css.php";

    private $defaultText = "default_text";
    private $hide = "hide";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {

        // Set CSS file
        $this->cssFile = sprintf( "%s/%s", self::$CSS_ROOT, $this->cssFile );
        $this->cssAppFile = sprintf( "%s/%s", self::$CSS_ROOT, $this->cssAppFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function getCssFile()
    {
        return $this->cssFile;
    }

    public function getDefaultText()
    {
        return $this->defaultText;
    }

    /**
     * @return CampusguideCssResource
     */
    public function campusguide()
    {
        self::$CAMPUSGUIDE = self::$CAMPUSGUIDE ? self::$CAMPUSGUIDE : new CampusguideCssResource();
        return self::$CAMPUSGUIDE;
    }

    // /FUNCTIONS


    public function getCssAppFile()
    {
        return $this->cssAppFile;
    }

    public function getHide()
    {
        return $this->hide;
    }

}

?>