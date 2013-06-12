<?php

class BuildingCmsUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getPage( $page, $mode = null, $url = "" )
    {
        return CmsUrlResource::getPage( BuildingsCmsMainController::$CONTROLLER_NAME, $page,
                $mode, $url );
    }

    // ... CONTROLLER


    public function getController( $mode = null, $url = "" )
    {
        return CmsUrlResource::getController( BuildingsCmsMainController::$CONTROLLER_NAME,
                $mode, $url );
    }

    private function getImageController( $id, $type, $width = null, $height = null, $mode = null, $url = "" )
    {
        return CmsUrlResource::getImageController( BuildingCmsImageController::$CONTROLLER_NAME,
                $id, $type, $width, $height, $mode, $url );
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

    // ... ... BUILDING CREATOR


    public function getBuildingcreatorPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_BUILDINGCREATOR, $mode,
                sprintf( "/%s%s", $action, $url ) );
    }

    public function getBuildingcreatorViewPage( $id, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorPage( CmsMainController::ACTION_VIEW, $mode,
                sprintf( "/%s%s", $id, $url ) );
    }

    public function getBuildingcreatorEditPage( $id, $type, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorPage( CmsMainController::ACTION_EDIT, $mode,
                sprintf( "/%s/%s%s", $id, $type, $url ) );
    }

    public function getBuildingcreatorEditFloorsPage( $id, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorEditPage( $id, BuildingsCmsMainController::TYPE_FLOORS, $mode, $url );
    }

    // ... ... /BUILDING CREATOR


    public function getFloorplannerPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_FLOORPLANNER, $mode, $url );
    }

    // ... ... BUILDING


    private static function getBuildingPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsMainController::PAGE_BUILDING, $mode,
                sprintf( "/%s%s", $action, $url ) );
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

    // ... ... /BUILDING


    // ... /PAGE


    public function getBuildingOverviewImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsImageController::$TYPE_OVERVIEW, $width,
                $height, $mode, $url );
    }

    public function getBuildingMapImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsImageController::$TYPE_MAP, $width,
                $height, $mode, $url );
    }

    // /FUNCTIONS


}

?>