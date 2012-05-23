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

    // /FUNCTIONS


}

?>