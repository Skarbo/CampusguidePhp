<?php

class EntryScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return EntryScheduleModel
     */
    public static function createEntrySchedule( $type, $timeStart = null, $timeEnd = null, array $occurence = array() )
    {

        // Initiate model
        $entrySchedule = new EntryScheduleModel();

        $entrySchedule->setType( Core::ucwords( Core::utf8Decode( $type ) ) );
        $entrySchedule->setTimeStart( Core::parseTimestamp( $timeStart ) );
        $entrySchedule->setTimeEnd( Core::parseTimestamp( $timeEnd ) );
        $entrySchedule->setOccurences(
                array_map( function ( $var )
                {
                    return Core::parseTimestamp( $var );
                }, $occurence ) );

        // Return model
        return $entrySchedule;

    }

    // /FUNCTIONS


}

?>