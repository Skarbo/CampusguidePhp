<?php

class BuildingCampusguideImageResource extends ClassCore
{

    // VARIABLES

    public static $BUILDING_MAP_SIZE_DEFAULT = array( 200, 100 );

    const BUILDING_OVERVIEW_WIDTH_DEFAULT = 200;
    const BUILDING_OVERVIEW_HEIGHT_DEFAULT = 100;

    private static $FOLDER_IMAGE_BUILDING = "building";
    private static $IMAGE_DEFAULT = "default_%sx%s.png";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    public static function getFolder( $mode = null )
    {
        return sprintf( "%s/%s", CampusguideImageResource::getFolder( $mode ), self::$FOLDER_IMAGE_BUILDING );
    }

    public function getBuildingOverview( $buildingId, $mode, $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return sprintf( "%s/%s_%sx%s.png", self::getFolder( $mode ), $buildingId, $width, $height );
    }

    public function getDefaultBuildingOverview( $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return sprintf( "%s/%s", self::getFolder(), sprintf( self::$IMAGE_DEFAULT, $width, $height ) );
    }

    // /FUNCTIONS


}

?>