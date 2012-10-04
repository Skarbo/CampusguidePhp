<?php

class QueueUtil extends ClassCore
{

    // VARIABLES


    public static $SPLITTER_ARGUMENTS = "$";
    public static $SPLITTER_ARGUMENT = "=";
    public static $SPLITTER_ARGUMENT_VALUE = ",";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param mixed $arguments
     * @return string
     */
    public static function generateArgumentsToString( $arguments )
    {
        return is_array( $arguments ) ? http_build_query( $arguments ) : $arguments;
    }

    /**
     * @param mixed $arguments
     * @return array
     */
    public static function generateArgumentsToArray( $arguments )
    {
        if ( is_string( $arguments ) )
        {
            $array = array ();
            parse_str( $arguments, $array );
            return $array;
        }
        return $arguments;
    }

    /**
     * @param array $argument1
     * @param array $argument2
     * @return array
     */
    public static function mergeArguments( array $argument1, array $argument2 )
    {
        return Core::arrayMerge( $argument1, $argument2 );
    }

    // /FUNCTIONS


}

?>