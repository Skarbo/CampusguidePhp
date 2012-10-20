<?php

class AdminCmsUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getPage( $page, $mode = null, $url = "" )
    {
        return CmsUrlResource::getPage( AdminCmsMainController::$CONTROLLER_NAME, $page, $mode, $url );
    }

    // ... CONTROLLER


    // ... /CONTROLLER


    // ... PAGE


    public function getOverviewPage( $mode = null, $url = "" )
    {
        return self::getPage( AdminCmsMainController::PAGE_OVERVIEW, $mode, $url );
    }

    public function getErrorsPage( $mode = null, $url = "" )
    {
        return self::getPage( AdminCmsMainController::PAGE_ERRORS, $mode, $url );
    }

    // ... ... QUEUE


    public function getQueuePage( $mode = null, $url = "" )
    {
        return self::getPage( AdminCmsMainController::PAGE_QUEUE, $mode, $url );
    }

    public function getQueuePageNew( $mode = null, $url = "" )
    {
        return $this->getQueuePage( $mode, sprintf( "/%s%s", CmsMainController::ACTION_NEW, $url ) );
    }

    public function getQueuePageNewScheduleEntriesRoom( $mode = null, $url = "" )
    {
        return $this->getQueuePageNew($mode, sprintf("//%s%s", AdminCmsMainController::TYPE_SCHEDULEENTRIESROOM, $url));
    }

    public function getQueuePageNewScheduleType( $mode = null, $url = "" )
    {
        return $this->getQueuePageNew($mode, sprintf("//%s%s", AdminCmsMainController::TYPE_TYPE, $url));
    }

    // ... ... /QUEUE


    // /FUNCTIONS


}

?>