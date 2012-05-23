<?php

class CampusguideApi extends PasswordCampusguideApi
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see Api::getLocale()
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
    }

    /**
     * @see Api::getDbbackupHandler()
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