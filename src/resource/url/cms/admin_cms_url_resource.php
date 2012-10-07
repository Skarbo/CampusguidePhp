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
        return CmsUrlResource::getPage( AdminCmsMainController::$CONTROLLER_NAME, $page,
                $mode, $url );
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

    // /FUNCTIONS


}

?>