<?php

class TypesTimeeditScheduleWebsiteAlgorithmParser extends TimeeditWebsiteAlgorithmParser
{

    // table#maintable td#contenttd form.form table[1] tbody tr[2] td[0] table tr[2>=i>n-2] td[4][text=(.+)]
    private static $SELECTOR_FORM_TABLES = "table#maintable td#contenttd form[name=form]";
    private static $SELECTOR_VERSION = "span#copyright";
    //*[@id="contenttd"]/form/table[2]/tbody/tr[1]/td[1]/table/tbody/tr[1]/td[3]/table/tbody/tr/td[1]/select


    public static $TYPES = array ( TypeScheduleModel::TYPE_FACULTY => 6, TypeScheduleModel::TYPE_GROUP => 5,
            TypeScheduleModel::TYPE_PROGRAM => 4, TypeScheduleModel::TYPE_ROOM => 7 );
    private static $TIMEEDIT_VERSION = "1.4.8";
    private static $REGEX_SEARCH_RESULT = '/.+: (\d+)-(\d+) \w+ (\d+)/s';
    private static $REGEX_VERSION = '/([\d.]+)/s';
    private static $REGEX_ILLEGAL_NAME = '/^[_-].*/';

    private $type;

    public function __construct( $type )
    {
        $this->type = $type;
    }

    /**
     * @see WebsiteAlgorithmParser::parseHtml()
     */
    public function parseHtml( simple_html_dom $html )
    {
        $result = new TypesTimeeditScheduleAlgorithmResultParser();

        // Correct version
        $version = $this->getVersion( $html );
        if ( $version != self::$TIMEEDIT_VERSION )
        {
            throw new ParserException(
                    sprintf( "Website version is \"%s\", algorithm is written for version \"%s\"", $version,
                            self::$TIMEEDIT_VERSION ), self::PARSER_EXCEPTION_WRONGVERSION );
        }

        // Is correct choosen type
        $choosenType = $this->getChoosenType( $html );
        if ( $choosenType != Core::arrayAt( self::$TYPES, $this->type ) )
        {
            throw new ParserException(
                    sprintf( "Choosen type \"%s\" does not match with given type \"%s\" (%s)", $choosenType,
                            Core::arrayAt( self::$TYPES, $this->type ), $this->type ),
                    self::PARSER_EXCEPTION_INCORRECTPATH );
        }

        // Get search result
        $searchResult = $this->getSearchResult( $html );
        if ( $searchResult )
        {
            $result->setStart( Core::arrayAt( $searchResult, 0 ) );
            $result->setEnd( Core::arrayAt( $searchResult, 1 ) );
            $result->setTotal( Core::arrayAt( $searchResult, 2 ) );
        }

        // Parse Type list
        try
        {
            $node = $html->find( self::$SELECTOR_FORM_TABLES, 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 1 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 2 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->find( "table tr" );
            if ( !$node )
                throw new Exception();
        }
        catch ( Exception $e )
        {
            throw new ParserException( "Incorrect type list path", self::PARSER_EXCEPTION_INCORRECTPATH, $e );
        }

        $typeList = self::generateTypeList( $this->type );
        for ( $i = 2; $i < count( $node ) - 2; $i++ )
        {
            $row = $node[ $i ];

            // Code
            $code = null;
            $codeNode = $row->children( 0 );
            if ( $codeNode )
            {
                $codeNode = $codeNode->children( 0 );
                if ( $codeNode && $codeNode->tag == "a" && $codeNode->href )
                {
                    $matches = array ();
                    if ( preg_match( '/javascript:addObject\((\d+)\)/i', $codeNode->href, $matches ) )
                        $code = $matches[ 1 ];
                }
            }

            // Room name
            $name = self::parseDom( $row->children( 4 ), "plaintext" );

            // Room name short
            $nameShort = self::parseDom( $row->children( 2 ), "plaintext" );

            // Create Type
            $typeModel = self::generateTypeModel( $this->type, $code, $name, $nameShort );

            if ( self::isValidType( $typeModel ) )
                $typeList->add( $typeModel );
        }

        $result->setTypes( $typeList );

        return $result;
    }

    /**
     * @param simple_html_dom $dom
     * @throws Exception
     * @return String Null if nothing choosen
     */
    private function getChoosenType( simple_html_dom $dom )
    {
        // Parse correct type
        try
        {
            $node = $dom->find( self::$SELECTOR_FORM_TABLES, 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 1 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->find( "table", 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->find( "select option" );
            if ( !$node )
                throw new Exception();
        }
        catch ( Exception $e )
        {
            throw new Exception( "Incorrect type path", 0, $e );
        }

        for ( $i = 0; $i < count( $node ); $i++ )
        {
            $option = $node[ $i ];
            if ( $option->hasAttribute( "selected" ) )
            {
                return $option->getAttribute( "value" );
            }
        }
        return null;
    }

    // /html/body/table/tbody/tr[2]/td/form/table[2]/tbody/tr[3]/td/table/tbody/tr/td/b
    /**
     * @return array Array( start, end, total )
     */
    private function getSearchResult( simple_html_dom $dom )
    {
        try
        {
            $node = $dom->find( self::$SELECTOR_FORM_TABLES, 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 1 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 2 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->find( "table tr", 0 );
            if ( !$node )
                throw new Exception();
            $node = $node->children( 0 );
            if ( !$node )
                throw new Exception();

            $text = Core::trimWhitespace( $node->plaintext );
            $matches = array ();
            preg_match_all( self::$REGEX_SEARCH_RESULT, $text, $matches );
            return array ( intval( $matches[ 1 ][ 0 ] ), intval( $matches[ 2 ][ 0 ] ), intval( $matches[ 3 ][ 0 ] ) );
        }
        catch ( Exception $e )
        {
            throw new ParserException( "Incorrect search result path", self::PARSER_EXCEPTION_INCORRECTPATH, $e );
        }
    }

    // //*[@id="copyright"]
    /**
     * @param simple_html_dom $dom
     * @throws Exception
     * @return string Version
     */
    private function getVersion( simple_html_dom $dom )
    {
        $node = $dom->find( self::$SELECTOR_VERSION, 0 );
        if ( !$node )
            throw new Exception( "Incorrect version path" );

        $text = Core::trimWhitespace( $node->plaintext );
        $matches = array ();
        if ( preg_match( self::$REGEX_VERSION, $text, $matches ) )
            return $matches[ 0 ];
        return null;
    }

    /**
     * @return TypeScheduleListModel
     */
    private static function generateTypeList( $type )
    {
        switch ( $type )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                return new FacultyScheduleListModel();
                break;
            case TypeScheduleModel::TYPE_GROUP :
                return new GroupScheduleListModel();
                break;
            case TypeScheduleModel::TYPE_PROGRAM :
                return new ProgramScheduleListModel();
                break;
            case TypeScheduleModel::TYPE_ROOM :
                return new RoomScheduleListModel();
                break;
        }
        return null;
    }

    /**
     * @return TypeScheduleModel
     */
    private static function generateTypeModel( $type, $code, $name, $nameShort )
    {
        switch ( $type )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                return FacultyScheduleFactoryModel::createFacultySchedule( $code, $name, $nameShort );
                break;
            case TypeScheduleModel::TYPE_GROUP :
                return GroupScheduleFactoryModel::createGroupSchedule( $code, $name, $nameShort );
                break;
            case TypeScheduleModel::TYPE_PROGRAM :
                return ProgramScheduleFactoryModel::createProgramSchedule( $code, $name, $nameShort );
                break;
            case TypeScheduleModel::TYPE_ROOM :
                return RoomScheduleFactoryModel::createRoomSchedule( 0, $code, $name, $nameShort );
                break;
        }
        return null;
    }

    private static function isValidType( TypeScheduleModel $type )
    {
        return !preg_match( self::$REGEX_ILLEGAL_NAME, $type->getName() ) && !preg_match( self::$REGEX_ILLEGAL_NAME,
                $type->getNameShort() );
    }

}

?>