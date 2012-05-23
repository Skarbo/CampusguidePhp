<?php

class MapAppCampusguideMainController extends AppCampusguideMainController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "map";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AppCampusguideMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "MapAppCampusguideMainController";
    }

    /**
     * @see AppCampusguideMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "MapAppCampusguideMainView";
    }

    /**
     * @see AppCampusguideMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return MapAppCampusguideMainView::$ID_APP_WRAPPER;
    }

    /**
     * @see CampusguideMainController::getControllerName()
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
     * @see Controller::request()
     */
    public function request()
    {
        // TODO Auto-generated method stub


    }

    // /FUNCTIONS


}

?>