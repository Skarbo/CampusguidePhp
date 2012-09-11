<?php

abstract class CampusguideRestController extends RestController implements CampusguideInterfaceController
{

    // VARIABLES


    /**
     * @var CampusguideHandler
     */
    private $campusguideHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->campusguideHandler = new CampusguideHandler( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see CampusguideInterfaceController::getCampusguideHandler()
     */
    public function getCampusguideHandler()
    {
        return $this->campusguideHandler;
    }

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