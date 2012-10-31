<?php

class IconImageResource extends ClassCore
{

    // VARIABLES


    private $spinnerBar = "image/icon/spinner_bar.gif";
    private $spinnerCircle = "image/icon/spinner_circle.gif";

    private $roomAuditoriumSvg = "room_auditorium";
    private $roomCafeteriaSvg = "room_cafeteria";
    private $roomClassSvg = "room_class";
    private $roomElevatorSvg = "room_elevator";
    private $roomStairsSvg = "room_stairs";

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

    // ... ROOM


    public function getRoomSvg( $room, $color = null )
    {
        switch ( $room )
        {
            case ElementBuildingModel::TYPE_ROOM_AUDITORIUM :
                return $this->getRoomAuditoriumSvg( $color );
            case ElementBuildingModel::TYPE_ROOM_CAFETERIA :
                return $this->getRoomCafeteriaSvg( $color );
            case ElementBuildingModel::TYPE_ROOM_CLASS :
                return $this->getRoomClassSvg( $color );
            case ElementBuildingModel::TYPE_ROOM_ELEVATOR :
                return $this->getRoomElevatorSvg( $color );
            case ElementBuildingModel::TYPE_ROOM_STAIRS :
                return $this->getRoomStairsSvg( $color );
        }
        return Resource::image()->getEmptyImage();
    }

    public function getRoomAuditoriumSvg( $color = null )
    {
        return self::getSvg( $this->roomAuditoriumSvg, $color );
    }

    public function getRoomCafeteriaSvg( $color = null )
    {
        return self::getSvg( $this->roomCafeteriaSvg, $color );
    }

    public function getRoomClassSvg( $color = null )
    {
        return self::getSvg( $this->roomClassSvg, $color );
    }

    public function getRoomElevatorSvg( $color = null )
    {
        return self::getSvg( $this->roomElevatorSvg, $color );
    }

    public function getRoomStairsSvg( $color = null )
    {
        return self::getSvg( $this->roomStairsSvg, $color );
    }

    // ... /ROOM


}

?>