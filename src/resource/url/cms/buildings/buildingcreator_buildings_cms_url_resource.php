<?php

class BuildingcreatorBuildingsCmsUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getAction( $action, $mode = null, $url = "" )
    {
        return BuildingsCmsUrlResource::getPage( BuildingsCmsMainController::PAGE_BUILDINGCREATOR, $mode,
                sprintf( "/%s%s", $action, $url ) );
    }

    public function getViewAction( $id, $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_VIEW, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getEditAction( $id, $mode = null, $url = "" )
    {
        return self::getAction( CmsMainController::ACTION_EDIT, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    // /FUNCTIONS


}

?>