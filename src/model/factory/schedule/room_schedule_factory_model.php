<?php

class RoomScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return RoomScheduleModel
     */
    public static function createRoomSchedule( $elementId, $code, $name = null, $nameShort = null )
    {

        // Initiate model
        $roomSchedule = new RoomScheduleModel();

        $roomSchedule->setElementId( intval( $elementId ) );
        $roomSchedule->setCode( intval( $code ) );
        $roomSchedule->setName( Core::utf8Decode( $name ) );
        $roomSchedule->setNameShort( Core::utf8Decode( $nameShort ) );

        // Return model
        return $roomSchedule;

    }

    // /FUNCTIONS


}

?>