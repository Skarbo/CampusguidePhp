<?php

abstract class ImageController extends Controller
{

    // VARIABLES


    const QUERY_OPACITY = "opacity";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return int Opacity given in query, 0 if not given
     */
    public static function getOpacityQuery()
    {
        return intval( Core::arrayAt( self::getQuery(), self::QUERY_OPACITY, 0 ) );
    }

    // /FUNCTIONS


}

?>