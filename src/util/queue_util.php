<?php

class QueueUtil extends ClassCore
{

    // VARIABLES


    public static $SPLITTER_ARGUMENTS = "|";
    public static $SPLITTER_ARGUMENT = "$";
    public static $SPLITTER_ARGUMENT_VALUE = ",";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param mixed $arguments
     * @return string "variable$value[,value]|..."
     */
    public static function generateArgumentsToString( $arguments )
    {
        if ( is_array( $arguments ) )
        {
            return Core::arrayImplode( $arguments, self::$SPLITTER_ARGUMENTS, self::$SPLITTER_ARGUMENT,
                    function ( $value )
                    {
                        return is_array( $value ) ? implode( QueueUtil::$SPLITTER_ARGUMENT_VALUE, $value ) : $value;
                    } );
        }
        else if ( is_string( $arguments ) )
        {
            return $arguments;
        }
        return "";
    }

    /**
     * @param mixed $arguments
     * @return array array( "variable" = "value", ... )
     */
    public static function generateArgumentsToArray( $arguments )
    {
        if ( is_string( $arguments ) )
        {
            return Core::arrayExplode( $arguments, self::$SPLITTER_ARGUMENTS, self::$SPLITTER_ARGUMENT,
                    function ( $value )
                    {
                        return strpos($value, QueueUtil::$SPLITTER_ARGUMENT_VALUE) !== false ? explode( QueueUtil::$SPLITTER_ARGUMENT_VALUE, $value ) : $value;
                    } );
        }
        else if ( is_array( $arguments ) )
        {
            return $arguments;
        }
        return array ();
    }

    public static function mergeArguments( array $argument1, array $argument2 )
    {
        $newArgument = $argument1;

        foreach ( $argument2 as $key => $value )
        {
            if ( array_key_exists( $key, $newArgument ) && ( is_array( $value ) || is_array( $newArgument[ $key ] ) ) )
            {
                $newArgument[ $key ] = array_filter( array_merge( array(), array_unique(
                        array_merge( is_array( $value ) ? $value : array ( $value ),
                                is_array( $newArgument[ $key ] ) ? $newArgument[ $key ] : array ( $newArgument[ $key ] ) ) ) ), function( $var ) { return Core::empty_($var); } );
            }
            else
            {
                $newArgument[ $key ] = $value;
            }
        }

        return $newArgument;
    }

    // /FUNCTIONS


}

?>