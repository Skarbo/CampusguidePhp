<?php

class IconImageResource extends ClassCore
{

    // VARIABLES


    private $spinnerBar = "image/icon/spinner_bar.gif";
    private $spinnerCircle = "image/icon/spinner_circle.gif";

    private $roomAuditoriumSvg = "room_auditorium";
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

    private static function getSvg( $svg, $color = null )
    {
        return sprintf( self::$SVG, $svg, $color ? sprintf( "&color=%s", urlencode( $color ) ) : "" );
    }

    public function getRoomAuditoriumSvg( $color = null )
    {
        return self::getSvg( $this->roomAuditoriumSvg, $color );
    }

}

?>