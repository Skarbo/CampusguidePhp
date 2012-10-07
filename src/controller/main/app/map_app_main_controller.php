<?php

class MapAppMainController extends AppMainController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "map";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "MapAppMainController";
    }

    /**
     * @see AppMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "MapAppMainView";
    }

    /**
     * @see AppMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return MapAppMainView::$ID_APP_WRAPPER;
    }

    /**
     * @see MainController::getControllerName()
     */
    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    // ... /GET


    public function after()
    {
        parent::after();

        // Add Google maps
        $this->addJavascriptMap();

        // Add jquery drag api file
        $this->addJavascriptFile( Resource::javascript()->getJqueryDragApiFile() );

    }

    /**
     * @see AbstractController::request()
     */
    public function request()
    {
        // TODO Auto-generated method stub


    }

    // /FUNCTIONS


}

?>