<?php

class TestEntriesTimeeditScheduleWebsiteAlgorithmParser extends EntriesTimeeditScheduleWebsiteAlgorithmParser
{

    public static $PATH_ENTRIES_ROOM = "example/timeedit/entries_room.htm";
    public static $PATH_TOOMANYWEEKS = "example/timeedit/toomanyweeks.htm";

    public static $ENTRY_OCCURENCES = array ( 2, 2, 2, 2, 4, 2, 2, 2, 2, 2, 2, 2, 2, 2 );
    public static $ENTRY_DATES = array ( array ( 1348437600, 1349042400 ), array ( 1348437600, 1349042400 ),
            array ( 1348437600, 1349042400 ), array ( 1348524000, 1349128800 ),
            array ( 1348524000, 1348610400, 1349128800, 1349215200 ), array ( 1348524000, 1349128800 ),
            array ( 1348524000, 1349128800 ), array ( 1348610400, 1349215200 ), array ( 1348610400, 1349215200 ),
            array ( 1348696800, 1349301600 ), array ( 1348696800, 1349301600 ), array ( 1348696800, 1349301600 ),
            array ( 1348783200, 1349388000 ), array ( 1348783200, 1349388000 ) );
    public static $ENTRY_TIMES = array ( array ( "09:05", "11:45" ), array ( "12:15", "13:55" ),
            array ( "14:05", "15:45" ), array ( "08:15", "09:55" ), array ( "10:05", "11:45" ),
            array ( "12:15", "13:55" ), array ( "14:05", "15:45" ), array ( "08:15", "09:55" ),
            array ( "14:05", "15:45" ), array ( "10:05", "11:45" ), array ( "12:15", "13:55" ),
            array ( "14:05", "15:45" ), array ( "10:05", "11:45" ), array ( "12:15", "13:50" ) );
    public static $ENTRY_GROUPS = array ( array ( "10HLOG", "10HADM", "10HSAMFØ", "10HREGN", "11HØA3" ),
            array ( "10HLOG", "10HADM", "10HSAMFØ", "10HREGN", "11HØA3" ), array ( "12HØA3" ), array ( "11HMMT" ),
            array ( "12HØA3" ), array ( "12HØA3" ), array ( "12HØA3" ), array ( "10HDATA", "10HINF" ),
            array ( "10HLOG", "10HADM", "10HSAMFØ", "10HREGN", "11HØA3" ), array ( "10HMPR" ), array ( "10HMPR" ),
            array ( "10HMPR" ), array ( "11HETK" ), array ( "12HØA3" ) );
    public static $ENTRY_PROJECTS = array ( array ( "FOA041" ), array ( "ØBR102" ), array ( "ØMO001" ),
            array ( "TOM033" ), array ( "ØMO001" ), array ( "ØMO004" ), array ( "ØMO004" ), array ( "TOD121", "TOD142" ),
            array ( "ØBR102" ), array ( "TOM038" ), array ( "TOM038" ), array ( "TOM038" ), array ( "TOK005" ),
            array ( "ØMO001" ) );
    public static $ENTRY_ROOMS = array ( array ( "A622" ), array ( "A622" ), array ( "JacobEides", "A622" ),
            array ( "A622" ), array ( "JacobEides", "A622" ), array ( "A726", "A622" ), array ( "A726", "A622" ),
            array ( "A622" ), array ( "A622" ), array ( "A622" ), array ( "A622" ), array ( "A622" ), array ( "A622" ),
            array ( "A622" ) );
    public static $ENTRY_TYPE = array ( "Undervisning", "Undervisning", "Undervisning", "Øvingstime", "Undervisning",
            "laboratorium undervisning", "laboratorium undervisning", "Undervisning", "Undervisning", "Undervisning",
            "Undervisning", "Gruppearbeid", "Undervisning", "Regneøvelse" );
    public static $ENTRY_FACULTIES = array ( array ( "Heggholmen Kari" ), array ( "Dahle Torstein" ),
            array ( "Simonsen Terje" ), array ( "Student assistent" ), array ( "Simonsen Terje", "Grong", "Erlend" ),
            array ( "Amland Øystein", "Heggernes Tarjei" ), array ( "Amland Øystein", "Heggernes Tarjei" ),
            array ( "Hetland Kristin Fanebust", "Høyland Sven-Olai", "Wang YI", "Simonsen Kent Inge" ),
            array ( "Dahle Torstein" ), array ( "Stokke Leif" ), array ( "Stokke Leif" ), array ( "Stokke Leif" ),
            array ( "Førland Geir Martin" ), array ( "Simonsen Terje" ) );

}

class EntriesTimeeditScheduleWebsiteParserTest extends WebsiteParserTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "EntriesTimeeditScheduleWebsiteParser test" );
        TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS = Core::utf8Decode(
                TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS );
        TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_FACULTIES = Core::utf8Decode(
                TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_FACULTIES );
        TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS = Core::utf8Decode(
                TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS );
        TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_PROJECTS = Core::utf8Decode(
                TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_PROJECTS );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testTest()
    {
        $getInitials = function ( $name )
        {
            //split name using spaces
            $words = explode( " ", $name );
            $inits = '';
            //loop through array extracting initial letters
            foreach ( $words as $word )
            {
                $inits .= strtoupper( substr( $word, 0, 1 ) );
            }
            return $inits;
        };

        $string = "&lt;TR&gt;
&lt;TD&gt;&lt;a href='javascript:addObject(%s)'&gt;&lt;img src='/img/plus.gif' width='12' height='12' border='0' alt=''&gt;&lt;/a&gt;&lt;/TD&gt;
&lt;TD&gt;&nbsp;&nbsp;&nbsp;&lt;/TD&gt;
&lt;TD nowrap&gt;%s&lt;/TD&gt;
&lt;TD&gt;&nbsp;&nbsp;&nbsp;&lt;/TD&gt;
&lt;TD colspan='3'&gt;%s&lt;/TD&gt;
&lt;/TR&gt;";

        $types = array();
        foreach (TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_PROJECTS as $type)
        {
            $types = array_unique( array_merge($types, $type) );
        }
        foreach ($types as $i => $type)
        {
            echo sprintf($string, $i + 401, $type, $type) ."<br />";
        }

    }

    public function _testTooManyWeeks()
    {
        try
        {
            $this->websiteParser->parse(
                    self::getWebpage( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$PATH_TOOMANYWEEKS ),
                    new TestEntriesTimeeditScheduleWebsiteAlgorithmParser() );
            $this->fail( "Should throw ParserException" );
        }
        catch ( ParserException $e )
        {
            $this->assertEqual( TimeeditWebsiteAlgorithmParser::PARSER_EXCEPTION_TOOMANYWEEKS, $e->getCustomCode() );
        }
    }

    public function _testEntriesDuplicate()
    {
        $entry1 = EntryScheduleFactoryModel::createEntrySchedule( "type", strtotime( "28.09.2012 12:00" ),
                strtotime( "28.09.2012 13:00" ) );
        $entry2 = EntryScheduleFactoryModel::createEntrySchedule( "type", strtotime( "25.09.2012 12:00" ),
                strtotime( "25.09.2012 13:00" ) );
        $this->assertTrue( $entry1->isEqual( $entry2 ) );

        $entry3 = EntryScheduleFactoryModel::createEntrySchedule( "type", strtotime( "12:00" ), strtotime( "13:15" ) );
        $this->assertFalse( $entry1->isEqual( $entry3 ) );

        $entry2->getFaculties()->add( FacultyScheduleFactoryModel::createFacultySchedule( null, "Faculty Name" ) );
        $this->assertFalse( $entry1->isEqual( $entry2 ) );

        $entry1->getFaculties()->add( FacultyScheduleFactoryModel::createFacultySchedule( null, "Faculty Name Diff" ) );
        $this->assertFalse( $entry1->isEqual( $entry2 ) );

        $entry1->getFaculties()->removeAll();
        $entry1->getFaculties()->add( FacultyScheduleFactoryModel::createFacultySchedule( null, "Faculty Name" ) );
        $this->assertTrue( $entry1->isEqual( $entry2 ) );

        $entry1->getRooms()->add( RoomScheduleFactoryModel::createRoomSchedule( null, null, "", "Room" ) );
        $this->assertFalse( $entry1->isEqual( $entry2 ) );

        $entry2->getRooms()->add( RoomScheduleFactoryModel::createRoomSchedule( null, null, "", "Room Diff" ) );
        $this->assertFalse( $entry1->isEqual( $entry2 ) );

        $entry2->getRooms()->removeAll();
        $entry2->getRooms()->add( RoomScheduleFactoryModel::createRoomSchedule( null, null, "", "Room" ) );
        $this->assertTrue( $entry1->isEqual( $entry2 ) );

        $entry1->addOccurence( strtotime( "25.09.2012" ) );
        $entry2->addOccurence( strtotime( "29.09.2012" ) );

        $entry1->merge( $entry2 );
        $this->assertEqual( 2, count( $entry1->getOccurences() ) );

        $entries = new EntryScheduleListModel();
        $entries->addEntry( $entry1 );
        $entries->addEntry( $entry2 );
        $this->assertEqual( 1, $entries->size() );
    }

    private function deepSort( &$a )
    {
        $c = count( $a );
        for ( $i = 0; $i < $c; $i++ )
            if ( is_array( $a[ $i ] ) )
                sort( $a[ $i ] );
    }

    public function _testEntriesTimeeditParser()
    {
        $entries = EntryScheduleListModel::get_(
                $this->websiteParser->parse(
                        self::getWebpage( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$PATH_ENTRIES_ROOM ),
                        new TestEntriesTimeeditScheduleWebsiteAlgorithmParser() ) );

        $this->deepSort( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_DATES );
        $this->deepSort( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_FACULTIES );
        $this->deepSort( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS );
        $this->deepSort( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_PROJECTS );
        $this->deepSort( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_ROOMS );

        if ( $this->assertEqual( count( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_DATES ),
                $entries->size() ) )
        {
            for ( $entries->rewind(), $i = 0; $entries->valid(); $entries->next(), $i++ )
            {
                $entry = $entries->current();

                $this->assertEqual( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_TIMES[ $i ][ 0 ],
                        date( "H:i", $entry->getTimeStart() ), "%s - index ${i}" );
                $this->assertEqual( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_TIMES[ $i ][ 1 ],
                        date( "H:i", $entry->getTimeEnd() ), "%s - index ${i}" );

                if ( $this->assertEqual( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_OCCURENCES[ $i ],
                        count( $entry->getOccurences() ) ) )
                {
                    foreach ( $entry->getOccurences() as $j => $occurence )
                    {
                        $this->assertEqual(
                                TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_DATES[ $i ][ $j ], $occurence );
                    }
                }
                $this->doTestTypes( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_FACULTIES[ $i ],
                        $entry->getFaculties(), $i );
                $this->doTestTypes( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_GROUPS[ $i ],
                        $entry->getGroups(), $i );
                $this->doTestTypes( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_PROJECTS[ $i ],
                        $entry->getPrograms(), $i );
                $this->doTestTypes( TestEntriesTimeeditScheduleWebsiteAlgorithmParser::$ENTRY_ROOMS[ $i ],
                        $entry->getRooms(), $i );
            }
        }
    }

    private function doTestTypes( array $typesCorrect, TypeScheduleListModel $types, $i )
    {
        if ( $this->assertEqual( count( $typesCorrect ), $types->size(),
                "%s - Index ${i}, class " . get_class( $types ) ) )
        {
            for ( $types->rewind(), $j = 0; $types->valid(); $types->next(), $j++ )
            {
                $type = $types->current();

                $this->assertEqual( $typesCorrect[ $j ], $type->getNameShort() );
            }
        }
    }

    // /FUNCTIONS


}

?>