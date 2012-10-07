<?php

class AdminCmsMainController extends CmsMainController implements ErrorsAdminCmsInterfaceView
{

    // VARIABLES


    public static $CONTROLLER_NAME = "admin";

    const PAGE_ERRORS = "errors";

    /**
     * @var ErrorListModel
     */
    private $errors;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->errors = $this->getDaoContainer()->getErrorDao()->getAll();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... IS


    public function isPageErrors()
    {
        return $this->getPage() == self::PAGE_ERRORS;
    }

    // ... /IS


    // ... GET


    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    protected function getJavascriptView()
    {
        return "AdminCmsMainView";
    }

    /**
     * @see MainController::getErrors()
     */
    public function getErrors()
    {
        return $this->errors;
    }

    // ... /GET


    // /FUNCTIONS


}

?>