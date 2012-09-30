<?php

class GroupScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return GroupScheduleModel
     */
    public static function createGroupSchedule( $code, $name, $nameShort = null )
    {

        // Initiate model
        $groupSchedule = new GroupScheduleModel();

        $groupSchedule->setCode( intval( $code ) );
        $groupSchedule->setName( Core::utf8Decode( $name ) );
        $groupSchedule->setNameShort( Core::utf8Decode( $nameShort ) );

        // Return model
        return $groupSchedule;

    }

    // /FUNCTIONS


}

?>