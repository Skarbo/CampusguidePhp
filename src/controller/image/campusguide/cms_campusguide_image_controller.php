<?php

abstract class CmsCampusguideImageController extends CampusguideImageController
{

    // VARIABLES


    const URI_ID = 1;
    const URI_TYPE = 2;
    const URI_SIZE = 3;

    protected static $IMAGE_SIZE_CACHE = array ( array ( 100, 50 ), array ( 150, 75 ), array ( 200, 100 ) );
    protected static $IMAGE_SIZE_DEFAULT = array ( 200, 100 );

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return int Id given in URI
     */
    protected static function getIdURI()
    {
        return intval( self::getURI( self::URI_ID ) );
    }

    /**
     * @return string Type given in URI
     */
    protected static function getTypeURI()
    {
        return self::getURI( self::URI_TYPE );
    }

    /**
     * @return array Array( width, height ) Size given in URI, empty array if none given
     */
    protected static function getSizeURI()
    {
        return array_map( function ( $var )
        {
            return intval( $var );
        }, explode( CampusguideImageResource::$SIZE_SPLITTER, self::getURI( self::URI_SIZE ) ) );
    }

    /**
     * @return string Image url
     */
    public abstract function getImage();

    /**
     * @param array Image size default
     * @return array Array( width, height )
     */
    protected static function getSizeWidthSize( array $default = array() )
    {
        return Core::arrayEquals( self::getSizeURI(), self::$IMAGE_SIZE_CACHE ) ? self::getSizeURI() : ( empty(
                $default ) ? self::$IMAGE_SIZE_DEFAULT : $default );
    }

    // ... /GET


    // ... DO


    /**
     * Do cache image
     *
     * @param string $imagePath Path to cache image to
     * @param string $imageUrl Image to cache
     * @throws Exception
     */
    protected function doCacheImage( $imagePath, $imageUrl )
    {

        // Create folders
        if ( !Core::createFolders( $imagePath ) )
        {
            throw new Exception( sprintf( "Can't create folders \"%s\"", $imagePath ) );
        }

        // File contents
        $fileContents = @file_get_contents( $imageUrl );

        // Cache image
        if ( $fileContents )
        {
            DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "Cache image", $imagePath, $imageUrl ) );

            file_put_contents( $imagePath, $fileContents );
        }
        // Throw error
        else
        {
            throw new Exception( sprintf( "Can't get contents for url \"%s\"", $imageUrl ) );
        }

    }

    // ... /DO


    // /FUNCTIONS


}

?>