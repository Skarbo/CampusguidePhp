<?php

class DbbackupHandlerTest extends DaoTest
{

    // VARIABLES


    /**
     * @var DbbackupHandler
     */
    private $dbbackupHandler;
    private $source;

    private static $DBBACKUP_FOLDER_TEST = "test";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "DbbackupHandler Test" );

        $this->source = sprintf( "%s%s%s",
                realpath(
                        sprintf( "%s%s..%s..%s..", dirname( __FILE__ ), DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR,
                                DIRECTORY_SEPARATOR ) ), DIRECTORY_SEPARATOR, self::$DBBACKUP_FOLDER_TEST );

        $this->dbbackupHandler = new DbbackupHandler( self::$DB_CONFIG_LOCALHOST_TEST[ "host" ],
                self::$DB_CONFIG_LOCALHOST_TEST[ "user" ], self::$DB_CONFIG_LOCALHOST_TEST[ "pass" ],
                array ( self::$DB_CONFIG_LOCALHOST_TEST[ "db" ] ), $this->source );
    }

    // /CONSTRUCTOR


    // FUNCTIONS

    public function testShouldBackupDatabase()
    {

        // Make source dir
        if ( !file_exists( $this->source ) )
        {
            mkdir( $this->source );
        }

        // Set backup hadler time
        $this->dbbackupHandler->setTime(strtotime("+2 hours"));

        // Handle
        $this->dbbackupHandler->handle();

    }

    // /FUNCTIONS


}

?>