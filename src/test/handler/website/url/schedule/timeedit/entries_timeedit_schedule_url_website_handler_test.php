<?php

class EntriesTimeeditScheduleUrlWebsiteHandlerTest extends ClassCore implements EntriesScheduleUrlWebsiteHandler
{

    // VARIABLES


    public static $PATH_TIMEEDIT_TOOMANYWEEKS = "example/timeedit/toomanyweeks.htm";
    public static $PATH_TIMEEDIT_ENTRIESROOM = "example/timeedit/entries_room.htm";
    private static $MAX_TYPES = 4;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see EntriesScheduleUrlWebsiteHandler::getEntriesUrl()
     */
    public function getEntriesUrl( $url, TypeScheduleListModel $types, $startWeek, $endWeek )
    {
        if ( $types->size() >= self::$MAX_TYPES )
            return sprintf( $url, self::$PATH_TIMEEDIT_TOOMANYWEEKS );

        return sprintf( $url, self::$PATH_TIMEEDIT_ENTRIESROOM );
    }

    // /FUNCTIONS


}

?>