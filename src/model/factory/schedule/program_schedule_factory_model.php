<?php

class ProgramScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return ProgramScheduleModel
     */
    public static function createProgramSchedule( $code, $name, $nameShort = null )
    {

        // Initiate model
        $programSchedule = new ProgramScheduleModel();

        $programSchedule->setCode( intval( $code ) );
        $programSchedule->setName( Core::utf8Decode( $name)  );
        $programSchedule->setNameShort( Core::utf8Decode( $nameShort ) );

        // Return model
        return $programSchedule;

    }

    // /FUNCTIONS


}

?>