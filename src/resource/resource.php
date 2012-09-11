<?php

class Resource extends AbstractResource
{

    // VARIABLES


    protected static $CSS, $DB, $IMAGE, $JAVASCRIPT, $URL;

    public static $COORDINATES_POLYGONS_SPLITTER = "$";
    public static $COORDINATES_SPLITTER = "|";
    public static $COORDINATE_SPLITTER = ",";
    public static $COORDINATE_CONTROL_SPLITTER = "%";

    private static $GOOGLE_API_KEY = "AIzaSyBy5yabtN3ZFIlRM8-NEghybXTCZ-UQ7Dk";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return CssResource
     */
    public static function css()
    {
        self::$CSS = self::$CSS ? self::$CSS : new CssResource();
        return self::$CSS;
    }

    /**
     * @return DbResource
     */
    public static function db()
    {
        self::$DB = self::$DB ? self::$DB : new DbResource();
        return self::$DB;
    }

    /**
     * @return ImageResource
     */
    public static function image()
    {
        self::$IMAGE = self::$IMAGE ? self::$IMAGE : new ImageResource();
        return self::$IMAGE;
    }

    /**
     * @return JavascriptResource
     */
    public static function javascript()
    {
        self::$JAVASCRIPT = self::$JAVASCRIPT ? self::$JAVASCRIPT : new JavascriptResource();
        return self::$JAVASCRIPT;
    }

    /**
     * @return UrlResource
     */
    public static function url()
    {
        self::$URL = self::$URL ? self::$URL : new UrlResource();
        return self::$URL;
    }

    //     /**
    //      * @param array $coordinates
    //      * @return string String("x,y|x,y")
    //      */
    //     public static function generateCoordinatesToString( array $coordinates )
    //     {
    //         return implode( self::$COORDINATES_SPLITTER,
    //                 array_map(
    //                         function ( $coordinate )
    //                         {
    //                             return is_array( $coordinate ) ? implode( Resource::$COORDINATE_SPLITTER, $coordinate ) : $coordinate;
    //                         }, $coordinates ) );
    //     }


    /**
     * @param array $coordinates
     * @return string String("x,y|x,y")
     */
    public static function generateCoordinatesToString( array $coordinates )
    {
        if ( empty( $coordinates ) )
            return "";
        return implode( self::$COORDINATES_POLYGONS_SPLITTER,
                array_map(
                        function ( $polygon )
                        {
                            return implode( Resource::$COORDINATES_SPLITTER,
                                    array_map(
                                            function ( $coordinate )
                                            {
                                                $i = 0;
                                                return implode( Resource::$COORDINATE_SPLITTER,
                                                        array_map(
                                                                function ( $var ) use(&$i )
                                                                {
                                                                    $i++;
                                                                    if ( $i < 3 + 1 )
                                                                        return $var;
                                                                    if ( !is_array( $var ) )
                                                                        return null;
                                                                    return implode(
                                                                            Resource::$COORDINATE_CONTROL_SPLITTER,
                                                                            ( array ) $var );
                                                                }, ( array ) $coordinate ) );
                                            }, ( array ) $polygon ) );
                        }, $coordinates ) );
    }

    /**
     * @param mixed $coordinates Array( Array( x, y ) )|String("x,y|x,y")
     * @return array Array( Array( x, y ) )
     */
    public static function generateCoordinatesToArray( $coordinates )
    {
        if ( empty( $coordinates ) )
            return array();
        return !is_array( $coordinates ) ? array_map(
                function ( $polygon )
                {
                    return array_map(
                            function ( $coordinate )
                            {
                                $i = 0;
                                return array_map(
                                        function ( $var ) use(&$i )
                                        {
                                            $i++;
                                            if ( $i < 2 + 1 )
                                                return floatval( $var );
                                            else if ( $i == 2 + 1 )
                                                return $var;
                                            if ( Core::isEmpty( $var ) )
                                                return null;
                                            return array_map(
                                                    function ( $var )
                                                    {
                                                        return floatval( $var );
                                                    }, explode( Resource::$COORDINATE_CONTROL_SPLITTER, $var ) );
                                        }, explode( Resource::$COORDINATE_SPLITTER, $coordinate ) );
                            }, explode( Resource::$COORDINATES_SPLITTER, $polygon ) );
                }, explode( self::$COORDINATES_POLYGONS_SPLITTER, $coordinates ) ) : $coordinates;
    }

    public static function getGoogleApiKey()
    {
        return self::$GOOGLE_API_KEY;
    }

    // /FUNCTIONS


}

?>