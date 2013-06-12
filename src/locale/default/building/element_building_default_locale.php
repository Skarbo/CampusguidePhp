<?php

class ElementBuildingDefaultLocale extends Locale
{

    // VARIABLES


    public $typeGroupRoom = "Room";
    public $typeRoomAuditorium = "Auditorium";
    public $typeRoomCafeteria = "Cafeteria";
    public $typeRoomClassroom = "Classroom";
    public $typeRoomElevator = "Elevator";
    public $typeRoomStairs = "Stairs";
    public $typeRoomTerrace = "Terrace";
    public $typeRoomWc = "WC";

    public $typeDeviceRouter = "Router";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTypeGroup( $typeGroup )
    {
        switch ( $typeGroup )
        {
            case ElementBuildingModel::TYPE_GROUP_ROOM :
                return $this->typeGroupRoom;
        }
        return "Unassigned";
    }

    public function getType( $type )
    {
        switch ( $type )
        {
            case ElementBuildingModel::TYPE_ROOM_AUDITORIUM :
                return $this->typeRoomAuditorium;
            case ElementBuildingModel::TYPE_ROOM_CAFETERIA :
                return $this->typeRoomCafeteria;
            case ElementBuildingModel::TYPE_ROOM_CLASS :
                return $this->typeRoomClassroom;
            case ElementBuildingModel::TYPE_ROOM_ELEVATOR :
                return $this->typeRoomElevator;
            case ElementBuildingModel::TYPE_ROOM_STAIRS :
                return $this->typeRoomStairs;
            case ElementBuildingModel::TYPE_ROOM_TERRACE:
                return $this->typeRoomTerrace;
            case ElementBuildingModel::TYPE_ROOM_WC:
                return $this->typeRoomWc;

            case ElementBuildingModel::TYPE_DEVICE_ROUTER:
                return $this->typeDeviceRouter;
        }
        return "Unassigned";
    }

    // /FUNCTIONS


}

?>