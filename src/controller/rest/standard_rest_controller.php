<?php

abstract class StandardRestController extends AbstractStandardRestController implements InterfaceController
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->daoContainer = new DaoContainer( $this->getDbApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see InterfaceController::getDaoContainer()
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }


    // /FUNCTIONS


}

?>