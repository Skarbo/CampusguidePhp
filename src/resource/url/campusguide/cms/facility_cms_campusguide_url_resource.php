<?php

class FacilityCmsCampusguideUrlResource extends ClassCore
{

    // VARIABLES


    private static $PAGE_OVERVIEW = "overview";
    private static $PAGE_MAP = "map";
    private static $PAGE_FACILITY = "facility";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    private static function getPage( $page, $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getPage( FacilitiesCmsCampusguideMainController::$CONTROLLER_NAME, $page,
                $mode, $url );
    }

    public function getController( $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getController( FacilitiesCmsCampusguideMainController::$CONTROLLER_NAME,
                $mode, $url );
    }

    private function getImageController( $id, $type, $width = null, $height = null, $mode = null, $url = "" )
    {
        return CmsCampusguideUrlResource::getImageController( FacilityCmsCampusguideImageController::$CONTROLLER_NAME, $id, $type,
                $width, $height, $mode, $url );
    }

    // ... PAGE


    public function getOverviewPage( $mode = null, $url = "" )
    {
        return self::getPage( self::$PAGE_OVERVIEW, $mode, $url );
    }

    public function getMapPage( $mode = null, $url = "" )
    {
        return self::getPage( self::$PAGE_MAP, $mode, $url );
    }

    // ... ... FACILITY


    private static function getFacilityPage( $action, $mode = null, $url = "" )
    {
        return self::getPage( self::$PAGE_FACILITY, $mode, sprintf( "/%s%s", $action, $url ) );
    }

    public function getViewFacilityPage( $id, $mode = null, $url = "" )
    {
        return self::getFacilityPage( FacilitiesCmsCampusguideMainController::ACTION_VIEW, $mode,
                sprintf( "/%s%s", $id, $url ) );
    }

    public function getNewFacilityPage( $mode = null, $url = "" )
    {
        return self::getFacilityPage( FacilitiesCmsCampusguideMainController::ACTION_NEW, $mode, $url );
    }

    public function getEditFacilityPage( $id, $mode = null, $url = "" )
    {
        return self::getFacilityPage( FacilitiesCmsCampusguideMainController::ACTION_EDIT, $mode,
                sprintf( "/%s%s", $id, $url ) );
    }

    public function getDeleteFacilityPage( array $ids, $mode = null, $url = "" )
    {
        return self::getFacilityPage( FacilitiesCmsCampusguideMainController::ACTION_DELETE, $mode,
                sprintf( "/%s%s", implode( FacilitiesCmsCampusguideMainController::$ID_SPLITTER, $ids ), $url ) );
    }

    // ... ... /FACILITY


    // ... /PAGE


    public function getFacilityImage( $facilityId, $width = null, $height = null, $mode = null,  $url = "" )
    {
        return self::getImageController( $facilityId, "", $width, $height, $mode, $url );
    }

    // /FUNCTIONS


}

?>