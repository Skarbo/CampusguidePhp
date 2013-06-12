<?php

class ElementBuildingImageResource extends ClassCore
{

    private $elementsSvg = "room";
    private $roomSvg = "room";
    private $roomAuditoriumSvg = "room_auditorium";
    private $roomCafeteriaSvg = "room_cafeteria";
    private $roomClassSvg = "room_class";
    private $roomElevatorSvg = "room_elevator";
    private $roomStairsSvg = "room_stairs";
    private $roomWcSvg = "room_wc";

    private $deviceRouterSvg = "element_device_router";

    public function getElements( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->elementsSvg, $stroke, $fill );
    }

    public function getTypeGroup( $typeGroup, $stroke = null, $fill = null )
    {
        switch ( $typeGroup )
        {
            case ElementBuildingModel::TYPE_GROUP_ROOM :
                return IconImageResource::getSvg( $this->roomSvg, $stroke, $fill );
        }
        return Resource::image()->getEmptyImage();
    }

    public function getType( $type, $stroke = null, $fill = null )
    {
        switch ( $type )
        {
            case ElementBuildingModel::TYPE_ROOM_AUDITORIUM :
                return $this->getRoomAuditorium( $stroke, $fill );
            case ElementBuildingModel::TYPE_ROOM_CAFETERIA :
                return $this->getRoomCafeteria( $stroke, $fill );
            case ElementBuildingModel::TYPE_ROOM_CLASS :
                return $this->getRoomClass( $stroke, $fill );
            case ElementBuildingModel::TYPE_ROOM_ELEVATOR :
                return $this->getRoomElevator( $stroke, $fill );
            case ElementBuildingModel::TYPE_ROOM_STAIRS :
                return $this->getRoomStairs( $stroke, $fill );
            case ElementBuildingModel::TYPE_ROOM_WC :
                return $this->getRoomWc( $stroke, $fill );

            case ElementBuildingModel::TYPE_DEVICE_ROUTER :
                return $this->getDeviceRouter( $stroke, $fill );
        }
        return Resource::image()->getEmptyImage();
    }

    public function getRoomAuditorium( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomAuditoriumSvg, $stroke, $fill );
    }

    public function getRoomCafeteria( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomCafeteriaSvg, $stroke, $fill );
    }

    public function getRoomClass( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomClassSvg, $stroke, $fill );
    }

    public function getRoomElevator( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomElevatorSvg, $stroke, $fill );
    }

    public function getRoomStairs( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomStairsSvg, $stroke, $fill );
    }

    public function getRoomWc( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->roomWcSvg, $stroke, $fill );
    }

    public function getDeviceRouter( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->deviceRouterSvg, $stroke, $fill );
    }

}

?>