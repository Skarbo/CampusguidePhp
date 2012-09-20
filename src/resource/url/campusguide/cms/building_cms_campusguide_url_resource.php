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

    private function getImageController( $id, $type, $width = null, $height = null, $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getImageController( BuildingCmsCampusguideImageController::$CONTROLLER_NAME,
                $id, $type, $width, $height, $mode, $url );
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

    // ... ... BUILDING CREATOR


    public function getBuildingcreatorPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( BuildingsCmsCampusguideMainController::PAGE_BUILDINGCREATOR, $mode,
                sprintf( "/%s%s", $action, $url ) );
    }

    public function getBuildingcreatorViewPage( $id, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorPage( CmsCampusguideMainController::ACTION_VIEW, $mode,
                sprintf( "/%s%s", $id, $url ) );
    }

    public function getBuildingcreatorEditPage( $id, $type, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorPage( CmsCampusguideMainController::ACTION_EDIT, $mode,
                sprintf( "/%s/%s%s", $id, $type, $url ) );
    }

    public function getBuildingcreatorEditFloorsPage( $id, $mode = null, $url = "" )
    {
        return $this->getBuildingcreatorEditPage( $id, BuildingsCmsCampusguideMainController::TYPE_FLOORS, $mode, $url );
    }

    // ... ... /BUILDING CREATOR


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


    public function getBuildingOverviewImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsCampusguideImageController::$TYPE_OVERVIEW, $width,
                $height, $mode, $url );
    }

    public function getBuildingMapImage( $buildingId, $width = null, $height = null, $mode = null, $url = "" )
    {
        return self::getImageController( $buildingId, BuildingCmsCampusguideImageController::$TYPE_MAP, $width,
                $height, $mode, $url );
    }

    // /FUNCTIONS


}

?>