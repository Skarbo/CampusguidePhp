<?php

class BuildingCmsCampusguideUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getPage( $page, $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getPage( BuildingsCmsCampusguideMainController::$CONTROLLER_NAME, $page,
                $mode, $url );
    }

    // ... CONTROLLER


    public function getController( $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getController( BuildingsCmsCampusguideMainController::$CONTROLLER_NAME,
                $mode, $url );
    }

    public function getImageController( $id, $width = null, $height = null, $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getImageController( BuildingCmsCampusguideImageController::$CONTROLLER_NAME, $id,
                $width, $height, $mode, $url );
    }

    // ... /CONTROLLER


    // ... PAGE


    public function getOverviewPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsCampusguideMainController::PAGE_OVERVIEW, $mode, $url );
    }

    public function getMapPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsCampusguideMainController::PAGE_MAP, $mode, $url );
    }

    public function getFloorplannerPage( $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsCampusguideMainController::PAGE_FLOORPLANNER, $mode, $url );
    }

    // ... ... BUILDING


    private static function getBuildingPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsCampusguideMainController::PAGE_BUILDING, $mode,
                sprintf( "/%s%s", $action, $url ) );
    }

    public function getViewBuildingPage( $id, $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsCampusguideMainController::ACTION_VIEW, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    public function getNewBuildingPage( $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsCampusguideMainController::ACTION_NEW, $mode, $url );
    }

    public function getEditBuildingPage( $id, $mode = null, $url = "" )
    {
        return self::getBuildingPage( CmsCampusguideMainController::ACTION_EDIT, $mode, sprintf( "/%s%s", $id, $url ) );
    }

    // ... ... /BUILDING


    // ... /PAGE


    public function getBuildingImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, $width, $height, $mode, $url );
    }

    // /FUNCTIONS


}

?>