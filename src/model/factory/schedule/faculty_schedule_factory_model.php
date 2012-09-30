<?php

class FacultyScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return FacultyScheduleModel
     */
    public static function createFacultySchedule( $code, $name, $nameShort = null, $roomId = null, $type = null, $phone = null, $email = null )
    {

        // Initiate model
        $facultySchedule = new FacultyScheduleModel();

        $facultySchedule->setRoomId( intval( $roomId ) );
        $facultySchedule->setCode( intval( $code ) );
        $facultySchedule->setType( $type );
        $facultySchedule->setName( Core::utf8Decode( $name ) );
        $facultySchedule->setNameShort( Core::utf8Decode( $nameShort ) );
        $facultySchedule->setPhone( $phone );
        $facultySchedule->setEmail( $email );

        // Return model
        return $facultySchedule;

    }

    // /FUNCTIONS


}

?>