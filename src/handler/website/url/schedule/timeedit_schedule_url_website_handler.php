<?php

class TimeeditScheduleUrlWebsiteHandler extends ClassCore
{

    // VARIABLES


    protected static $REGEX_URL_SEARCH = '%(.+)/4DACTION/\w+/(\d+)/(\d+)%';
    protected static $REGEX_URL_NEW = '/timeedit.net/';

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $url
     * @return True if URL is the new Timeedit
     */
    protected function isNewTimeeditVersion( $url )
    {
        return preg_match( self::$REGEX_URL_NEW, $url );
    }

    /**
     * @return array Array( base url, institute, language )
     */
    protected function getUrlParts( $url )
    {
        $matches = array ();
        if ( !preg_match_all( self::$REGEX_URL_SEARCH, $url, $matches ) )
            throw new Exception( sprintf( "Timeedit url \"%s\" is not correct", $url ) );

        $baseUrl = $matches[ 1 ][ 0 ];
        $institute = $matches[ 2 ][ 0 ];
        $language = $matches[ 3 ][ 0 ];

        return array ( $baseUrl, $institute, $language );
    }

    // /FUNCTIONS


}

?>