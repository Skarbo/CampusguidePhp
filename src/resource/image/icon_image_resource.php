<?php

class IconImageResource extends ClassCore
{

    // VARIABLES


    private $spinnerBar = "image/icon/spinner_bar.gif";
    private $spinnerCircle = "image/icon/spinner_circle.gif";

    private $minusSvg = "minus";
    private $plusSvg = "plus";
    private $maximizeSvg = "maximize";
    private $upDoubleSvg = "up_double";
    private $downDoubleSvg = "down_double";
    private $settingsSvg = "settings";
    private $optionsSvg = "options";
    private $searchSvg = "search";
    private $crossSvg = "cross";

    private static $SVG = "svg.php?svg=%s%s";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getSpinnerBar()
    {
        return $this->spinnerBar;
    }

    public function getSpinnerCircle()
    {
        return $this->spinnerCircle;
    }

    public static function getSvg( $svg, $stroke = null, $fill = null )
    {
        return sprintf( self::$SVG, $svg,
                sprintf( "%s%s", $fill ? sprintf( "&fill=%s", urlencode( $fill ) ) : "",
                        $stroke ? sprintf( "&stroke=%s", urlencode( $stroke ) ) : "" ) );
    }

    public function getMinusSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->minusSvg, $stroke, $fill );
    }

    public function getPlusSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->plusSvg, $stroke, $fill );
    }

    public function getMaximizeSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->maximizeSvg, $stroke, $fill );
    }

    public function getDownDoubleSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->downDoubleSvg, $stroke, $fill );
    }

    public function getUpDoubleSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->upDoubleSvg, $stroke, $fill );
    }

    public function getSettingsSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->settingsSvg, $stroke, $fill );
    }

    public function getOptionsSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->optionsSvg, $stroke, $fill );
    }

    public function getSearchSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->searchSvg, $stroke, $fill );
    }

    public function getCrossSvg( $stroke = null, $fill = null )
    {
        return self::getSvg( $this->crossSvg, $stroke, $fill );
    }

    // ... ROOM


    // ... /ROOM


}

?>