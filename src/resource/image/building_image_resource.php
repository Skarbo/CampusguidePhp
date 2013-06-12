<?php

class BuildingImageResource extends ClassCore
{

    // VARIABLES

    private static $ELEMENT, $FLOOR;

    public static $BUILDING_MAP_SIZE_DEFAULT = array ( 200, 100 );

    const BUILDING_OVERVIEW_WIDTH_DEFAULT = 200;
    const BUILDING_OVERVIEW_HEIGHT_DEFAULT = 100;

    const BUILDING_MAP_WIDTH_DEFAULT = 200;
    const BUILDING_MAP_HEIGHT_DEFAULT = 100;

    private static $FOLDER_IMAGE_BUILDING = "building";
    private static $FOLDER_MAP_FLOOR_BUILDING = "floor";
    private static $IMAGE = "%s/%s_%s_%sx%s.png";
    private static $IMAGE_DEFAULT = "default_%s_%sx%s.png";
    /**
     * @var string [building id]_[floor id].png
     */
    private static $MAP_FLOOR_BUILDING = "%s/%s_%s.png";
    /**
     * @var string [coordinate,coordinate][width][height]
     */
    private static $BUILDING_MAP_URL = "http://maps.googleapis.com/maps/api/staticmap?center=%s&zoom=16&size=%sx%s&sensor=false";
    private static $BUILDING_MAP_OVERLAY_URL = "http://maps.googleapis.com/maps/api/staticmap?sensor=false&size=%sx%s&%s";
    private static $BUILDING_MAP_OVERLAY_PATH = "path=fillcolor:0x134F5C99|color:0xFFFFFF00|enc:%s";
    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    /**
     * @return ElementBuildingImageResource
     */
    public function element()
    {
        self::$ELEMENT = self::$ELEMENT ? self::$ELEMENT : new ElementBuildingImageResource();
        return self::$ELEMENT;
    }

    /**
     * @return FloorBuildingImageResource
     */
    public function floor()
    {
        self::$FLOOR = self::$FLOOR ? self::$FLOOR : new FloorBuildingImageResource();
        return self::$FLOOR;
    }


    public static function getFolder( $mode = null )
    {
        return sprintf( "%s/%s", ImageResource::getFolder( $mode ), self::$FOLDER_IMAGE_BUILDING );
    }

    public static function getFloorFolder( $mode )
    {
        return sprintf( "%s/%s", self::getFolder( $mode ), self::$FOLDER_MAP_FLOOR_BUILDING );
    }

    private function getBuildingImage( $buildingId, $mode, $type, $width, $height )
    {
        return sprintf( "%s/%s_%s_%sx%s.png", self::getFolder( $mode ), $buildingId, $type, $width, $height );
    }

    private function getBuildingDefault( $type, $width, $height )
    {
        return sprintf( "%s/%s", self::getFolder(), sprintf( self::$IMAGE_DEFAULT, $type, $width, $height ) );
    }

    // ... OVERVIEW


    public function getBuildingOverview( $buildingId, $mode, $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return self::getBuildingImage( $buildingId, $mode, BuildingCmsImageController::$TYPE_OVERVIEW, $width, $height );
    }

    public function getBuildingOverviewDefault( $width = self::BUILDING_OVERVIEW_WIDTH_DEFAULT, $height = self::BUILDING_OVERVIEW_HEIGHT_DEFAULT )
    {
        return self::getBuildingDefault( BuildingCmsImageController::$TYPE_OVERVIEW, $width, $height );
    }

    // ... /OVERVIEW


    // ... MAP


    public function getBuildingMap( $buildingId, $mode, $width = self::BUILDING_MAP_WIDTH_DEFAULT, $height = self::BUILDING_MAP_HEIGHT_DEFAULT )
    {
        return self::getBuildingImage( $buildingId, $mode, BuildingCmsImageController::$TYPE_MAP, $width, $height );
    }

    public function getBuildingMapDefault( $width = self::BUILDING_MAP_WIDTH_DEFAULT, $height = self::BUILDING_MAP_HEIGHT_DEFAULT )
    {
        return self::getBuildingDefault( BuildingCmsImageController::$TYPE_MAP, $width, $height );
    }

    public function getBuildingMapUrl( array $coordinates, $width = self::BUILDING_MAP_WIDTH_DEFAULT, $height = self::BUILDING_MAP_HEIGHT_DEFAULT )
    {
        return sprintf( self::$BUILDING_MAP_URL, implode( ",", $coordinates ), $width, $height );
    }

    public function getBuildingMapOverlayUrl( array $overlays, $width = self::BUILDING_MAP_WIDTH_DEFAULT, $height = self::BUILDING_MAP_HEIGHT_DEFAULT )
    {
        return sprintf( self::$BUILDING_MAP_OVERLAY_URL, $width, $height,
                implode( "&",
                        array_map(
                                function ( $var )
                                {
                                    return sprintf( self::$BUILDING_MAP_OVERLAY_PATH, $var );
                                }, $overlays ) ) );
    }

    // ... /MAP


    public function getBuildingFloorMap( $buildingId, $floorId, $mode )
    {
        return sprintf( self::$MAP_FLOOR_BUILDING, self::getFloorFolder( $mode ), $buildingId, $floorId );
    }

    // /FUNCTIONS


}

?>