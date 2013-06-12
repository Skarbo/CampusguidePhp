<?php

class TypesTimeeditScheduleUrlWebsiteHandler extends TimeeditScheduleUrlWebsiteHandler implements TypesScheduleUrlWebsiteHandler
{

    // VARIABLES


    /**
     * @example http://timeedit.hib.no/4DACTION/WebShowSearch/1/2-0?wv_type=4
     * @var string [base url][page][instite][language][type][page]
     */
    private static $URL_ADVANCEDSEARCH = "%s/4DACTION/%s/%s/%s-0?wv_type=%s&wv_first=%s&wv_next=Next+10";
    private static $PAGE_ADVANCEDSEARCH = "WebShowSearch";

    /**
     * @example http://no.timeedit.net/web/hib/db1/aistudent/objects?max=100&fr=t&partajax=t&im=f&sid=3&l=en_EN&types=4&start=0&part=t&media=html
     * @var string [base url][max][type][start]
     */
    private static $URL_TYPES_SEARCH = "%s/objects?max=%s&fr=t&partajax=t&im=f&sid=3&l=en_EN&types=%s&start=%s&part=t&media=html";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        $typeCode = Core::arrayAt( TypesTimeeditScheduleWebsiteAlgorithmParser::$TYPES, $type );
        if ( !$typeCode )
            throw new Exception( sprintf( "Timeedit type code for type \"%s\" does not exist", $type ) );

            // New TimeEdit website
        if ( $this->isNewTimeeditVersion( $url ) )
        {
            $max = 100;
            $start = ($page - 1) * $max;
            $urlSearch = sprintf( self::$URL_TYPES_SEARCH, $url, $max, $type, $start );
        }
        // Old TimeEdit website
        {

            $matches = array ();
            if ( !preg_match_all( self::$REGEX_URL_SEARCH, $url, $matches ) )
                throw new Exception( sprintf( "Timeedit url \"%s\" is not correct", $url ) );

            $baseUrl = $matches[ 1 ][ 0 ];
            $institute = $matches[ 2 ][ 0 ];
            $language = $matches[ 3 ][ 0 ];

            $searchPage = $page - 2;
            $urlSearch = sprintf( self::$URL_ADVANCEDSEARCH, $baseUrl, self::$PAGE_ADVANCEDSEARCH, $institute,
                    $language, $typeCode, $searchPage );

            return $urlSearch;

        }

        return null;
    }

    // /FUNCTIONS


}

?>