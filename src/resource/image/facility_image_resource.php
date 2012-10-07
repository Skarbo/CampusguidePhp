<?php

class FacilityImageResource extends ClassCore
{

    // VARIABLES


    const FACILITY_MAP_WIDTH = 200;
    const FACILITY_MAP_HEIGHT = 100;

    private static $FOLDER_IMAGE_FACILITY = "facility";
    private static $IMAGE_DEFAULT = "default_%sx%s.png";
    private static $URL_FACILITY_MAP = "http://maps.googleapis.com/maps/api/staticmap?size=%sx%s&markers=size:small|color:red|%s&sensor=false"; // widthXheight
    private static $URL_FACILITY_MAP_DEFAULT = "http://maps.googleapis.com/maps/api/staticmap?center=Bergen,Norway&zoom=12&size=%sx%s&sensor=false";


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getFolder( $mode = null )
    {
        return sprintf( "%s/%s", ImageResource::getFolder( $mode ), self::$FOLDER_IMAGE_FACILITY );
    }

    public function getFacilityMap( $facilityId, $mode, $width = self::FACILITY_MAP_WIDTH, $height = self::FACILITY_MAP_HEIGHT )
    {
        return sprintf( "%s/%s_%sx%s.png", self::getFolder( $mode ), $facilityId, $width, $height );
    }

    public function getDefaultFacilityMap( $width = self::FACILITY_MAP_WIDTH, $height = self::FACILITY_MAP_HEIGHT )
    {
        return sprintf( "%s/%s", self::getFolder(), sprintf( self::$IMAGE_DEFAULT, $width, $height ) );
    }

    public function getUrlFacilityMap( array $markers, $width = self::FACILITY_MAP_WIDTH, $height = self::FACILITY_MAP_HEIGHT )
    {
        return sprintf( self::$URL_FACILITY_MAP, $width, $height,
                implode( "|",
                        array_map(
                                function ( $var )
                                {
                                    return urlencode( $var );
                                }, $markers ) ) );
    }

    // /FUNCTIONS


}

?>