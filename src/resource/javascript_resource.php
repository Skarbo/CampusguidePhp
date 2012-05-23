<?php

class JavascriptResource extends AbstractJavascriptResource
{

    // VARIABLES


    private $javascriptFile = "campusguide.js.php?mode=%s";
    private $javascriptAppFile = "campusguide_app.js.php?mode=%s";
    private $googleMapsApiUrl = "http://maps.googleapis.com/maps/api/js?key=%s&sensor=%s&callback=%s";
    private $googleMapsApiFile = "google.maps.api.js";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct();

        $this->javascriptFile = sprintf( "%s/%s", self::$ROOT_FOLDER, $this->javascriptFile );
        $this->javascriptAppFile = sprintf( "%s/%s", self::$ROOT_FOLDER, $this->javascriptAppFile );
        $this->googleMapsApiFile = sprintf( "%s/%s/%s", self::$ROOT_FOLDER, self::$ROOT_API, $this->googleMapsApiFile );

    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function getJavascriptFile( $mode = null )
    {
        return sprintf( $this->javascriptFile, $mode );
    }

    public function getGoogleMapsApiUrl( $apiKey, $callback, $sensor = "false" )
    {
        return sprintf( $this->googleMapsApiUrl, $apiKey, $sensor, $callback );
    }

    public function getGoogleMapsApiFile()
    {
        return $this->googleMapsApiFile;
    }

    // /FUNCTIONS


    public function getJavascriptAppFile( $mode = null )
    {
        return sprintf( $this->javascriptAppFile, $mode );
    }

}

?>