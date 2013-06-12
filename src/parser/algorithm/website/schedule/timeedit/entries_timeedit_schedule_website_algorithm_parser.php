<?php

class EntriesTimeeditScheduleWebsiteAlgorithmParser extends TimeeditWebsiteAlgorithmParser
{

    // VARIABLES


    // /html/body/table/tbody/tr
    private static $SELECTOR_ENTRIES = "body table tr";
    private static $SELECTOR_TOOMANYWEEKS = "h1";

    private static $REGEX_WEEK = '/(\d{1,2}).+(\d{4})/s';
    private static $REGEX_DATE = '/(\w{3})\s(\d{1,2})/s';
    private static $REGEX_TIME = '/(\d{2}:\d{2}).+(\d{2}:\d{2})/s';

    private static $CLASS_BLANK = "blank";
    private static $SPLITTER = ", ";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... HTML DOM


    /**
     * @see WebsiteAlgorithmParser::parseHtml()
     */
    public function parseHtml( simple_html_dom $html )
    {
        // Too many weeks
        if ( $this->isTooManyWeeks( $html ) )
            throw new ParserException( "Too many weeks", self::PARSER_EXCEPTION_TOOMANYWEEKS );

        $entryNodes = $html->find( self::$SELECTOR_ENTRIES );
        if ( !$entryNodes )
            throw new ParserException( "Incorrect entries path", self::PARSER_EXCEPTION_INCORRECTPATH );

        $filterFunc = function ( $var )
        {
            return !empty( $var ) && $var != " " && $var != "&nbsp;";
        };

        $entries = new EntryScheduleListModel();
        $week = 0;
        $year = 0;
        $date = null;
        foreach ( $entryNodes as $i => $entryNode )
        {
            $node = $entryNode->children( 0 );
            if ( !$node )
                continue;

                // BLANK


            if ( $node->getAttribute( "class" ) == self::$CLASS_BLANK )
            {
                continue;
            }

            // /BLANK


            // WEEK


            if ( intval( $node->getAttribute( "colspan" ) ) > 0 )
            {
                $text = Core::trimWhitespace( $node->text() );
                $matches = array ();
                if ( preg_match_all( self::$REGEX_WEEK, $text, $matches ) )
                {
                    $week = $matches[ 1 ][ 0 ];
                    $year = $matches[ 2 ][ 0 ];
                    continue;
                }
            }

            // /WEEK


            if ( !$week || !$year )
                continue;

                // ENTRY


            // ... DATE
            $node = $entryNode->children( 1 );
            if ( $node )
            {
                $text = Core::trimWhitespace( $node->text() );
                if ( preg_match_all( self::$REGEX_DATE, $text, $matches ) )
                {
                    $month = $matches[ 1 ][ 0 ];
                    $day = $matches[ 2 ][ 0 ];
                    $date = strtotime( sprintf( "%s %s %s", $day, $month, $year ) );
                }
            }
            // ... /DATE


            // ... TIME
            $node = $entryNode->children( 2 );
            $timeStart = null;
            $timeEnd = null;
            if ( $node && $date )
            {
                $text = Core::trimWhitespace( $node->text() );
                if ( preg_match_all( self::$REGEX_TIME, $text, $matches ) )
                {
                    $timeStart = strtotime( $matches[ 1 ][ 0 ], $date );
                    $timeEnd = strtotime( $matches[ 2 ][ 0 ], $date );
                }
            }
            // ... /TIME


            // ... GROUP
            $node = $entryNode->children( 3 );
            $groups = new GroupScheduleListModel();
            if ( $node )
            {
                $text = Core::trimWhitespace( $node->text() );
                $groupsArray = array_filter( explode( self::$SPLITTER, $text ), $filterFunc );
                foreach ( $groupsArray as $groupString )
                {
                    $groups->add( GroupScheduleFactoryModel::createGroupSchedule( null, "", $groupString ) );
                }
            }
            // ... /GROUP


            // ... PROGRAM
            $node = $entryNode->children( 4 );
            $programs = new ProgramScheduleListModel();
            if ( $node )
            {
                $text = Core::trimWhitespace( $node->text() );
                $programsArray = array_filter( explode( self::$SPLITTER, $text ), $filterFunc );
                foreach ( $programsArray as $programString )
                {
                    $programs->add( ProgramScheduleFactoryModel::createProgramSchedule( null, "", $programString ) );
                }
            }
            // ... /PROGRAM


            // ... ROOM
            $node = $entryNode->children( 5 );
            $rooms = new RoomScheduleListModel();
            if ( $node )
            {
                $text = Core::trimWhitespace( $node->text() );
                $roomsArray = array_filter( explode( self::$SPLITTER, $text ), $filterFunc );
                foreach ( $roomsArray as $roomString )
                {
                    $rooms->add( RoomScheduleFactoryModel::createRoomSchedule( null, null, "", $roomString ) );
                }
            }
            // ... /ROOM


            // ... ENTRY TYPE
            $node = $entryNode->children( 6 );
            $entryType = self::parseDom( $node, "plaintext" );
            $entryType = $filterFunc( $entryType ) ? $entryType : null;
            // ... /ENTRY TYPE


            // ... FACULTY
            $node = $entryNode->children( 7 );
            $faculties = new FacultyScheduleListModel();
            if ( $node )
            {
                $text = Core::trimWhitespace( $node->text() );
                $facultiesArray = array_filter( explode( self::$SPLITTER, $text ), $filterFunc );
                foreach ( $facultiesArray as $facultyString )
                {
                    $faculties->add( FacultyScheduleFactoryModel::createFacultySchedule( null, $facultyString ) );
                }
            }
            // ... /FACULTY


            $entry = EntryScheduleFactoryModel::createEntrySchedule( $entryType, $timeStart, $timeEnd );

            $entry->addOccurence( $date );
            $entry->setFaculties( $faculties );
            $entry->setGroups( $groups );
            $entry->setPrograms( $programs );
            $entry->setRooms( $rooms );

            if ( $this->isEntryValid( $entry ) )
                $entries->addEntry( $entry );

            // /ENTRY


        }

        return $entries;
    }

    /**
     * @param EntryScheduleModel $entry
     * @return boolean True if Entry is valid
     */
    private function isEntryValid( EntryScheduleModel $entry )
    {
        return !$entry->getPrograms()->isEmpty() && !$entry->getGroups()->isEmpty() && !$entry->getRooms()->isEmpty() && !$entry->getFaculties()->isEmpty();
    }

    /**
     * @param simple_html_dom $dom
     * @return boolean True if too many weeks
     */
    private function isTooManyWeeks( simple_html_dom $dom )
    {
        $node = $dom->find( self::$SELECTOR_TOOMANYWEEKS );
        return $node != null;
    }

    // /HTML DOM


    /**
     * @see WebsiteAlgorithmParser::parseHtmlRaw()
     */
    public function parseHtmlRaw( $result )
    {



    }

    // /FUNCTIONS


}

?>