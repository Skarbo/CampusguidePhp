<?php

class QueueFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $type
     * @param int $priority
     * @param mixed $arguments
     * @return QueueModel
     */
    public static function createQueue( $type, $priority, $arguments = array() )
    {

        // Initiate model
        $queue = new QueueModel();

        $queue->setType( $type );
        $queue->setPriority( intval( $priority ) );
        $queue->setArguments( QueueUtil::generateArgumentsToArray( $arguments ) );

        // Return model
        return $queue;

    }

    /**
     * @param int $buildingId
     * @param mixed $arguments
     * @param int $priority
     * @return QueueModel
     */
    public static function createBuildingQueue( $buildingId, $arguments = array(), $priority = QueueModel::PRIORITY_LOW )
    {

        // Initiate model
        $queue = self::createQueue( QueueModel::TYPE_IMAGE_BUILDING, $priority, $arguments );

        $queue->setBuildingId( intval( $buildingId ) );

        // Return model
        return $queue;

    }

    /**
     * @param integer $websiteId
     * @param integer $scheduleType
     * @param integer $scheduleTypePage
     * @param integer $priority
     * @return QueueModel
     */
    public static function createScheduleTypesQueue( $websiteId, $scheduleType, $scheduleTypePage, $priority = QueueModel::PRIORITY_HIGH )
    {
        $arguments = array ();
        $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_PAGE ] = intval( $scheduleTypePage );
        $queue = self::createQueue( QueueModel::TYPE_SCHEDULE_TYPES, $priority, $arguments );

        $queue->setWebsiteId( intval( $websiteId ) );
        $queue->setScheduleType( $scheduleType );

        return $queue;
    }

    /**
     * @param integer $websiteId
     * @param integer $scheduleType
     * @param array $scheduleTypeIds Array( type id, ... )
     * @param array $scheduleTypeWeeks Array( start week, end week )
     * @param integer $scheduleTypeCodesPr Codes pr query
     * @param integer $priority
     * @return QueueModel
     */
    public static function createScheduleEntriesQueue( $websiteId, $scheduleType, array $scheduleTypeIds, array $scheduleTypeWeeks = array(), $scheduleTypeCodesPr = 0, $priority = QueueModel::PRIORITY_MEDIUM )
    {
        $arguments = array ();
        $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_IDS ] = $scheduleTypeIds;
        $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_WEEKS ] = $scheduleTypeWeeks;
        $arguments[ QueueModel::$ARGUMENT_SCHEDULE_TYPE_CODES_PR ] = intval( $scheduleTypeCodesPr );
        $queue = self::createQueue( QueueModel::TYPE_SCHEDULE_ENTRIES, $priority, $arguments );

        $queue->setWebsiteId( intval( $websiteId ) );
        $queue->setScheduleType( $scheduleType );

        return $queue;
    }

    // /FUNCTIONS


}

?>