<?php

class LogFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return LogModel
     */
    public static function createLog( $type, $text )
    {

        // Initiate model
        $log = new LogModel();

        $log->setType( $type );
        $log->setText( $text );

        // Return model
        return $log;

    }

    /**
     * @param id $websiteId
     * @param string $scheduleType
     * @param string $text
     * @return LogModel
     */
    public static function createScheduleTypeLog( $websiteId, $scheduleType, $text )
    {
        $log = self::createLog( LogModel::TYPE_SCHEDULE_TYPE, $text );
        $log->setWebsiteId( $websiteId );
        $log->setScheduleType( $scheduleType );
        return $log;
    }

    /**
     * @param id $websiteId
     * @param string $text
     * @return LogModel
     */
    public static function createScheduleEntriesLog( $websiteId, $text )
    {
        $log = self::createLog( LogModel::TYPE_SCHEDULE_ENTIRES, $text );
        $log->setWebsiteId( $websiteId );
        return $log;
    }

    public static function createScheduleEntriesToomanyweeksLog( $websiteId, $text )
    {
        $log = self::createLog( LogModel::TYPE_SCHEDULE_ENTIRES_TOOMANYWEEKS, $text );
        $log->setWebsiteId( $websiteId );
        return $log;
    }

    // /FUNCTIONS


}

?>