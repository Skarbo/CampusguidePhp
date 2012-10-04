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

        $matches = array ();
        if ( !preg_match_all( self::$REGEX_URL_SEARCH, $url, $matches ) )
            throw new Exception( sprintf( "Timeedit url \"%s\" is not correct", $url ) );

        $baseUrl = $matches[ 1 ][ 0 ];
        $institute = $matches[ 2 ][ 0 ];
        $language = $matches[ 3 ][ 0 ];

        $searchPage = $page - 2;
        $urlSearch = sprintf( self::$URL_ADVANCEDSEARCH, $baseUrl, self::$PAGE_ADVANCEDSEARCH, $institute, $language,
                $typeCode, $searchPage );

        return $urlSearch;
    }

    // /FUNCTIONS


}

?>