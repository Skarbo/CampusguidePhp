<?php

class CampusguideImageResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $FACILITY;

    public static $FOLDER_IMAGE = "image";
    public static $SIZE_SPLITTER = "x";

    private static $ROOT;

    // /VARIABLES


    // CONSTRUCTOR

    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getFolder( $mode = null )
    {
        self::$ROOT = self::$ROOT ? self::$ROOT : realpath( sprintf( "%s/../../../", dirname( __FILE__ ) ) );

        if ( $mode )
        {
            return sprintf( "%s/%s/%s", self::$ROOT, CampusguideImageResource::$FOLDER_IMAGE, $mode );
        }
        return sprintf( "%s/%s", self::$ROOT, CampusguideImageResource::$FOLDER_IMAGE );
    }

    /**
     * @return BuildingCampusguideImageResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingCampusguideImageResource();
        return self::$BUILDING;
    }

    /**
     * @return FacilityCampusguideImageResource
     */
    public function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityCampusguideImageResource();
        return self::$FACILITY;
    }

    // /FUNCTIONS


}

?>