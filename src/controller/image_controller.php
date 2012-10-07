<?php

abstract class ImageController extends AbstractController implements InterfaceController
{

    // VARIABLES


    // ... DAO


    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // ... /DAO


    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setDaoContainer( new DaoContainer( $this->getDbApi() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @see InterfaceController::getDaoContainer()
     */
    public function getDaoContainer()
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
     * @see AbstractController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    // ... /GET


    // /FUNCTIONS


}

?>