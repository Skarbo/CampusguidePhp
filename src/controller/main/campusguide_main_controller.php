<?php

abstract class CampusguideMainController extends MainController
{

    // VARIABLES


    // ... DAO


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;

    // ... /DAO


    /**
     * @var array
     */
    private $errors = array ();

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setCampusguideHandler( new CampusguideHandler( $this->getDbApi() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return CampusguideHandler
     */
    protected function getCampusguideHandler()
    {
        return $this->campusguideHandler;
    }

    /**
     * @param CampusguideHandler $campusguideHandler
     */
    private function setCampusguideHandler( CampusguideHandler $campusguideHandler )
    {
        $this->campusguideHandler = $campusguideHandler;
    }


    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @return array:
     */
    public function getErrors()
    {
        return $this->errors;
    }

    // ... /GET


    // ... ADD


    protected function addJavascriptMap()
    {

        $code = <<<EOD
$(document).ready(function() {
	var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "%s";
    document.body.appendChild(script);
} );

function initMap()
{
    eventHandler.handle(new MapinitEvent());
}
EOD;

        $this->addJavascriptCode(
                sprintf( $code, Resource::javascript()->getGoogleMapsApiUrl( Resource::getGoogleApiKey(), "initMap" ) ) );

    }

    /**
     * @param AbstractException $exception
     */
    public function addError( AbstractException $exception )
    {
        $this->errors[] = $exception;
    }

    // ... /ADD


    // ... GET


    /**
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see MainController::getTitle()
     */
    protected function getTitle()
    {
        return "Campusguide";
    }

    /**
     * @return string Controller name
     */
    public abstract function getControllerName();

    // ... /GET


    // /FUNCTIONS


}

?>