<?php

class BuildingsCmsUrlResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $BUILDINGCREATOR;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getPage( $page, $mode = null, $url = "" )
    {
        return CmsUrlResource::getPage( BuildingsCmsMainController::$CONTROLLER_NAME, $page, $mode, $url );
    }

    /**
     * @return BuildingBuildingsCmsUrlResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingBuildingsCmsUrlResource();
        return self::$BUILDING;
    }

    /**
     * @return BuildingcreatorBuildingsCmsUrlResource
     */
    public function buildingcreator()
    {
        self::$BUILDINGCREATOR = self::$BUILDINGCREATOR ? self::$BUILDINGCREATOR : new BuildingcreatorBuildingsCmsUrlResource();
        return self::$BUILDINGCREATOR;
    }

    // ... CONTROLLER


    public function getController( $mode = null, $url = "" )
    {
        return CmsUrlResource::getController( BuildingsCmsMainController::$CONTROLLER_NAME, $mode, $url );
    }

    private function getImageController( $id, $type, $width = null, $height = null, $mode = null, $url = "" )
    {
        return CmsUrlResource::getImageController( BuildingCmsImageController::$CONTROLLER_NAME, $id, $type, $width,
                $height, $mode, $url );
    }

    // ... /CONTROLLER


    // ... PAGE


    public function getOverviewPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_OVERVIEW, $mode, $url );
    }

    public function getMapPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_MAP, $mode, $url );
    }

    // ... ... BUILDING


    private static function getBuildingPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_BUILDING, $mode, sprintf( "/%s%s", $action, $url ) );
    }

    public function getViewBuildingPage( $id, $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsMainController::ACTION_VIEW, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getNewBuildingPage( $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsMainController::ACTION_NEW, $mode, $url );
    }

    public function getEditBuildingPage( $id, $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsMainController::ACTION_EDIT, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getDeleteBuildingPage( $id, $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsMainController::ACTION_DELETE, $mode,
                sprintf( "/%s%s", is_array( $id ) ? implode( CmsMainController::$ID_SPLITTER, $id ) : $id, $url ) );
    }

    // ... ... /BUILDING


    // ... /PAGE


    public function getBuildingOverviewImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsImageController::$TYPE_OVERVIEW, $width, $height,
                $mode, $url );
    }

    public function getBuildingMapImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsImageController::$TYPE_MAP, $width, $height, $mode,
                $url );
    }

    // /FUNCTIONS


}

?>