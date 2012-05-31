<?php

class BuildingUtil extends ClassCore
{

    // VARIABLES


    public static $SPLITTER_POSITIONS = "|";
    public static $SPLITTER_POSITION = ",";
    public static $SPLITTER_LOCATION = ",";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public static function generatePositionToString( $position )
    {
        return is_array( $position ) ? implode( self::$SPLITTER_POSITIONS,
                array_map(
                        function ( $var )
                        {
                            return is_array( $var ) ? implode( BuildingUtil::$SPLITTER_POSITION, $var ) : $var;
                        }, $position ) ) : $position;
    }

    public static function generatePositionToArray( $position )
    {
        return !is_array( $position ) ? array_map(
                function ( $var )
                {
                    return array_map(
                            function ( $var )
                            {
                                return floatval( $var );
                            }, explode( BuildingUtil::$SPLITTER_POSITION, $var, 2 ) );
                }, explode( self::$SPLITTER_POSITIONS, $position ) ) : array_map(
                function ( $var )
                {
                    return array_filter( array_map(
                            function ( $var )
                            {
                                return floatval( $var );
                            }, is_array( $var ) ? $var : explode( BuildingUtil::$SPLITTER_POSITION, $var, 2 ) ) );
                }, $position );
    }

    // /FUNCTIONS


}

?>