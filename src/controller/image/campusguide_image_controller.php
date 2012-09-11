<?php

abstract class CampusguideImageController extends ImageController implements CampusguideInterfaceController
{

    // VARIABLES


    // ... DAO


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;

    // ... /DAO


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
     * @see CampusguideInterfaceController::getCampusguideHandler()
     */
    public function getCampusguideHandler()
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
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    // ... /GET


    // /FUNCTIONS


}

?>