<?php

class ImageResource extends AbstractImageResource
{

    // VARIABLES


    private static $ICON, $BUILDING, $FACILITY;

    public static $FOLDER_IMAGE = "image";
    public static $SIZE_SPLITTER = "x";

    private static $ROOT;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function getFolder( $mode = null )
    {
        self::$ROOT = self::$ROOT ? self::$ROOT : realpath( sprintf( "%s/../../", dirname( __FILE__ ) ) );

        if ( $mode )
        {
            return sprintf( "%s/%s/%s", self::$ROOT, ImageResource::$FOLDER_IMAGE, $mode );
        }
        return sprintf( "%s/%s", self::$ROOT, ImageResource::$FOLDER_IMAGE );
    }

    /**
     * @return BuildingImageResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingImageResource();
        return self::$BUILDING;
    }

    /**
     * @return FacilityImageResource
     */
    public function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityImageResource();
        return self::$FACILITY;
    }

    /**
     * @return IconImageResource
     */
    public function icon()
    {
        self::$ICON = self::$ICON ? self::$ICON : new IconImageResource();
        return self::$ICON;
    }

    // /FUNCTIONS


}

?>