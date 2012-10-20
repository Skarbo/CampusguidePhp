<?php

class LogHandler extends Handler
{

    // VARIABLES


    /**
     * @var LogHandler
     */
    private static $INSTANCE;

    /**
     * @var LogDao
     */
    private $logDao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( LogDbDao $logDao )
    {
        $this->logDao = $logDao;

        self::$INSTANCE = $this;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param LogModel $log
     */
    public function handle( LogModel $log )
    {
        if ( $this->logDao )
            $this->logDao->add( $log );
    }

    /**
     * @param LogModel $log
     */
    public static function doLog( LogModel $log )
    {
        if ( self::$INSTANCE )
        {
            $instance = self::$INSTANCE;
            $instance->handle( $log );
        }
    }

    // /FUNCTIONS


}

?>