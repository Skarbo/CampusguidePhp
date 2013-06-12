<?php

class BuildingBuildingsCmsUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getAction( $action, $mode = null, $url = "" )
    {
        return BuildingsCmsUrlResource::getPage( BuildingsCmsMainController::PAGE_BUILDING, $mode,
                sprintf( "/%s%s", $action, $url ) );
    }

    public function getViewAction( $id, $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_VIEW, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getNewAction( $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_NEW, $mode, $url );
    }

    public function getEditAction( $id, $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_EDIT, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getDeleteAction( $id, $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_DELETE, $mode,
                sprintf( "/%s%s", is_array( $id ) ? implode( CmsMainController::$ID_SPLITTER, $id ) : $id, $url ) );
    }

    // /FUNCTIONS


}

?>