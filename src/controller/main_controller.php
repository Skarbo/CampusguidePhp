<?php

abstract class MainController extends AbstractMainController
{

    // VARIABLES


    // ... DAO


    /**
     * @var DaoContainer
     */
    private $daoContainer;

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

        $this->setDaoContainer( new DaoContainer( $this->getDbApi() ) );

        //$this->getDaoContainer()->getRoomScheduleDao()->mergeElements();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return DaoContainer
     */
    protected function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @param DaoContainer $daoContainer
     */
    private function setDaoContainer( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
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
                sprintf( $code, Resource::javascript()->getGoogleMapsApiUrl( Resource::getGoogleApiKey(), "initMap", "drawing,geometry" ) ) );

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
     * @see AbstractController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see AbstractMainController::getTitle()
     */
    protected function getTitle()
    {
        return "";
    }

    /**
     * @return string Controller name
     */
    public abstract function getControllerName();

    // ... /GET


    // /FUNCTIONS


}

?>