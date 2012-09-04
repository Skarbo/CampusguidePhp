<?php

class BuildingCampusguideImageResource extends ClassCore
{

    // VARIABLES


    public static $BUILDING_MAP_SIZE_DEFAULT = array ( 200, 100 );

    const BUILDING_OVERVIEW_WIDTH_DEFAULT = 200;
    const BUILDING_OVERVIEW_HEIGHT_DEFAULT = 100;

    private static $FOLDER_IMAGE_BUILDING = "building";
    private static $FOLDER_MAP_FLOOR_BUILDING = "floor";
    private static $IMAGE_DEFAULT = "default_%sx%s.png";
    /**
     * @var string [building id]_[floor id].png
     */
    private static $MAP_FLOOR_BUILDING = "%s/%s_%s.png";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getFolder( $mode = null )
    {
        return sprintf( "%s/%s", CampusguideImageResource::getFolder( $mode ), self::$FOLDER_IMAGE_BUILDING );
    }

    public static function getFloorFolder( $mode )
    {
        return sprintf( "%s/%s", self::getFolder( $mode ), self::$FOLDER_MAP_FLOOR_BUILDING );
    }

    public function getBuildingOverview( $buildingId, $mode, $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return sprintf( "%s/%s_%sx%s.png", self::getFolder( $mode ), $buildingId, $width, $height );
    }

    public function getDefaultBuildingOverview( $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return sprintf( "%s/%s", self::getFolder(), sprintf( self::$IMAGE_DEFAULT, $width, $height ) );
    }

    public function getBuildingFloorMap( $buildingId, $floorId, $mode )
    {
        return sprintf( self::$MAP_FLOOR_BUILDING, self::getFloorFolder( $mode ), $buildingId, $floorId );
    }

    // /FUNCTIONS


}

?>