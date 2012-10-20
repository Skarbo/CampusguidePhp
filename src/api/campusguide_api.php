<?php

class CampusguideApi extends PasswordCampusguideApi
{

    // VARIABLES


    /**
     * @var LogHandler
     */
    private $logHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $modeDefault = self::MODE_PROD )
    {
        parent::__construct( $modeDefault );

        $this->logHandler = new LogHandler( new LogDbDao( $this->getDbApi() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractApi::getLocale()
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
    }

    /**
     * @see AbstractApi::getDbbackupHandler()
     */
    protected function getDbbackupHandler()
    {

        // Get database config
        $databaseConfig = $this->getDatabaseConfig();

        list ( $dbHost, , $dbUser, $dbPassword ) = Core::arrayAt( $databaseConfig, self::MODE_TEST );

        // Get databases
        $databases = array_map(
                function ( $var )
                {
                    return Core::arrayAt( $var, 1 );
                }, $databaseConfig );

        // Return Dbbackup Handler
        return new DbbackupHandler( $dbHost, $dbUser, $dbPassword, $databases, realpath( "." ) );

    }

    // /FUNCTIONS


}

?>