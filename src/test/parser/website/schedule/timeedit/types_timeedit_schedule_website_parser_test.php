<?php

class TestTypesTimeeditScheduleWebsiteAlgorithmParser extends TypesTimeeditScheduleWebsiteAlgorithmParser
{

    public static $PATH_ROOMSEARCH = "example/timeedit/roomsearch.html";
    public static $PATH_GROUPSEARCH = "example/timeedit/groupsearch.html";

    public static $ROOM_CODE = array ( 476000, 477000, 2927000, 486000, 478000 );
    public static $ROOM_NAME = array ( "A622", "A623", "A625", "A830", "A627" );
    public static $ROOM_NAME_SHORT = array ( "A622", "A623", "A625", "A627", "A830" );
    public static $ROOM_SEARCH_RESULT = array ( 1, 5, 5, 1, 1 );

    public static $GROUP_CODE = array ( 332000, 316000, 2129000, 298000, 3631000, 3981000 );
    public static $GROUP_NAME = array ( "3 kl. Informasjonsteknologi", "3 kl. Informasjonsteknologi",
            "3 klasse Informasjonsteknologi", "3. Klasse Informasjonsteknologi", "2. Klasse Informasjonsteknologi",
            "1. klasse Informasjonsteknologi" );
    public static $GROUP_NAME_SHORT = array ( "05HINF", "08HINF", "09HINF", "10HINF", "11HINF", "12HINF" );
    public static $GROUP_SEARCH_RESULT = array ( 1, 6, 6, 1, 1 );

    public static function getWebpage( $path )
    {
        return "http://" . $_SERVER[ "HTTP_HOST" ] . dirname( $_SERVER[ "REQUEST_URI" ] ) . "/" . $path;
    }

}

class TypesTimeeditScheduleWebsiteParserTest extends WebsiteParserTest
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "TypesTimeeditScheduleWebsiteParser test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function testRoomParsingAdvancedsearchTestPage()
    {
        $this->doTestParsingAdvancedsearchTestPage(
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::getWebpage(
                        TestTypesTimeeditScheduleWebsiteAlgorithmParser::$PATH_ROOMSEARCH ), TypeScheduleModel::TYPE_ROOM,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$ROOM_CODE,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$ROOM_NAME,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$ROOM_NAME_SHORT,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$ROOM_SEARCH_RESULT );
    }

    public function testGroupParsingAdvancedsearchTestPage()
    {
        $this->doTestParsingAdvancedsearchTestPage(
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::getWebpage(
                        TestTypesTimeeditScheduleWebsiteAlgorithmParser::$PATH_GROUPSEARCH ),
                TypeScheduleModel::TYPE_GROUP, TestTypesTimeeditScheduleWebsiteAlgorithmParser::$GROUP_CODE,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$GROUP_NAME,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$GROUP_NAME_SHORT,
                TestTypesTimeeditScheduleWebsiteAlgorithmParser::$GROUP_SEARCH_RESULT );
    }

    private function doTestParsingAdvancedsearchTestPage( $url, $type, array $codes, array $names, array $namesShort, array $searchResult )
    {

        $result = TypesTimeeditScheduleAlgorithmResultParser::get_(
                $this->websiteParser->parse( $url, new TestTypesTimeeditScheduleWebsiteAlgorithmParser( $type ) ) );

        if ( $result == null )
        {
            $this->fail( "Result is null " );
        }
        else
        {
            // Search result
            $this->assertEqual( $searchResult[ 0 ], $result->getStart(),
                    sprintf( "Result search result start should be equal \"%s\" but is \"%s\"", $searchResult[ 0 ],
                            $result->getStart() ) );
            $this->assertEqual( $searchResult[ 1 ], $result->getEnd(),
                    sprintf( "Result search result end should be equal \"%s\" but is \"%s\"", $searchResult[ 1 ],
                            $result->getEnd() ) );
            $this->assertEqual( $searchResult[ 2 ], $result->getTotal(),
                    sprintf( "Result search result total should be equal \"%s\" but is \"%s\"", $searchResult[ 2 ],
                            $result->getTotal() ) );
            $this->assertEqual( $searchResult[ 3 ], $result->getPage(),
                    sprintf( "Result search result page should be equal \"%s\" but is \"%s\"", $searchResult[ 3 ],
                            $result->getPage() ) );
            $this->assertEqual( $searchResult[ 4 ], $result->getPages(),
                    sprintf( "Result search result pages should be equal \"%s\" but is \"%s\"", $searchResult[ 4 ],
                            $result->getPages() ) );

            // Type list
            $typeList = RoomScheduleListModel::get_( $result->getTypes() );

            if ( $typeList == null )
            {
                $this->fail( "Type list is null " );
            }
            else if ( $typeList->size() != count( $codes ) )
            {
                $this->fail(
                        sprintf( "Type list size should be \"%s\" but is \"%s\"", count( $codes ), $typeList->size() ) );
            }
            else
            {
                for ( $typeList->rewind(), $i = 0; $typeList->valid(); $typeList->next(), $i++ )
                {
                    $typeModel = $typeList->current();

                    $this->assertEqual( $codes[ $i ], $typeModel->getCode(),
                            sprintf( "Type code should be equal \"%s\" but is \"%s\"", $codes[ $i ],
                                    $typeModel->getCode() ) );
                    $this->assertEqual( $names[ $i ], $typeModel->getName(),
                            sprintf( "Type name should be equal \"%s\" but is \"%s\"", $names[ $i ],
                                    $typeModel->getName() ) );
                    $this->assertEqual( $namesShort[ $i ], $typeModel->getNameShort(),
                            sprintf( "Type name short should be equal \"%s\" but is \"%s\"", $namesShort[ $i ],
                                    $typeModel->getNameShort() ) );
                }
            }
        }

    }

    // /FUNCTIONS


}

?>