<?php

class EntriesTimeeditScheduleUrlWebsiteHandler extends TimeeditScheduleUrlWebsiteHandler implements EntriesScheduleUrlWebsiteHandler
{

    // VARIABLES


    /**
     * @example http://timeedit.hib.no/4DACTION/WebShowSearchPrint/1/2-0?wv_text=text&wv_obj1=3981000&wv_startWeek=1240&wv_stopWeek=1252
     * @var string [base url][page][instite][language][start week][stop week][objects]
     */
    private static $URL_ENTRIES = "%s/4DACTION/%s/%s/%s-0?wv_text=text&wv_startWeek=%s&wv_stopWeek=%s&%s";
    private static $PAGE_PRINT = "WebShowSearchPrint";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see EntriesScheduleUrlWebsiteHandler::getEntriesUrl()
     */
    public function getEntriesUrl( $url, TypeScheduleListModel $types, $startWeek, $endWeek )
    {
        list ( $baseUrl, $institute, $language ) = $this->getUrlParts( $url );

        $codes = $types->getCodes();
        $objects = array_map(
                function ( $var, $key )
                {
                    return sprintf( "wv_obj%s=%s", intval( $key ) + 1, $var );
                }, $codes, array_keys( $codes ) );

        return sprintf( self::$URL_ENTRIES, $baseUrl, $institute, $language, date( "Wy", $startWeek ),
                date( "Wy", $startWeek ), implode( "&", $objects ) );
    }

    // /FUNCTIONS


}

?>