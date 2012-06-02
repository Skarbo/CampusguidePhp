<?php

abstract class CmsCampusguideMainController extends CampusguideMainController
{

    // VARIABLES


    const URI_PAGE = 1;
    const URI_ACTION = 2;
    const URI_ID = 3;

    const ACTION_VIEW = "view";
    const ACTION_NEW = "new";
    const ACTION_EDIT = "edit";
    const ACTION_DELETE = "delete";

    public static $ID_SPLITTER = "_";

    private static $QUEUE_TYPES = array ( QueueModel::TYPE_IMAGE_BUILDING );

    /**
     * @var QueueModel
     */
    private $queue;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return QueueModel
     */
    public function getQueue()
    {
        return $this->queue;
    }

    /**
     * @param QueueModel $queue
     */
    public function setQueue( QueueModel $queue )
    {
        $this->queue = $queue;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return int Id given in URI, null if none given
     */
    protected static function getId()
    {
        return Core::arrayAt( self::getIds(), 0, null );
    }

    /**
     * @return int Id's given in URI
     */
    protected static function getIds()
    {
        return array_filter(
                array_map(
                        function ( $val )
                        {
                            return intval( $val );
                        }, explode( self::$ID_SPLITTER, self::getURI( self::URI_ID ) ) ) );
    }

    /**
     * @return string Page given i URI, null if none given
     */
    protected static function getPage()
    {
        return self::getURI( self::URI_PAGE );
    }

    /**
     * @return string Action given i URI, null if none given
     */
    protected static function getAction()
    {
        return self::getURI( self::URI_ACTION );
    }

    /**
     * @return string Success query
     */
    public static function getQuerySuccess()
    {
        return Core::arrayAt( self::getQuery(), CmsCampusguideUrlResource::$QUERY_SUCCESS );
    }

    // ... ... /STATIC


    /**
     * @see MainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "%s - %s", "Control Management System", parent::getTitle() );
    }

    /**
     * @see CampusguideMainController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see Controller::getLocale()
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
    }

    /**
     * @return string Javascript controller
     */
    protected abstract function getJavascriptController();

    /**
     * @return string Javascript view
     */
    protected abstract function getJavascriptView();

    /**
     * @return string View wrapper id
     */
    protected abstract function getViewWrapperId();

    // ... /GET


    // ... IS


    /**
     * Default action
     *
     * @return boolean True if action is view
     */
    public function isActionView()
    {
        return self::getAction() == self::ACTION_VIEW;
    }

    /**
     * @return boolean True if action is new
     */
    public function isActionNew()
    {
        return self::getAction() == self::ACTION_NEW;
    }

    /**
     * @return boolean True if action is edit
     */
    public function isActionEdit()
    {
        return self::getAction() == self::ACTION_EDIT;
    }

    /**
     * @return boolean True if action is delete
     */
    public function isActionDelete()
    {
        return self::getAction() == self::ACTION_DELETE;
    }

    // ... /IS



    /**
     * @see MainController::after()
     */
    public function after()
    {
        parent::after();

        // Add Javascript files
        $this->addJavascriptFile( Resource::javascript()->getJqueryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryDragApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryHistoryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJavascriptFile( $this->getMode() ) );

        // ... Queue
        if ( $this->getQueue() && $this->getQueue()->getType() == QueueModel::TYPE_IMAGE_BUILDING )
        {
            $this->addJavascriptFile( Resource::javascript()->getKineticApiFile() );
        }

        // Add CSS files
        $this->addCssFile( Resource::css()->getCssFile() );

        // Create javscript body
        $codeBody = <<<EOD
    eventHandler = new EventHandler();
    view = new %s("%s");
    controller = new %s(eventHandler, %d, %s);
    controller.render(view);
EOD;

        $codeBody = sprintf( $codeBody, $this->getJavascriptView(), $this->getViewWrapperId(),
                $this->getJavascriptController(), $this->getMode(),
                json_encode(
                        array ( "page" => self::getPage(), "action" => self::getAction(), "id" => self::getId(),
                                "ids" => self::getIds() ) ) );

        // ... Queue
        if ( $this->getQueue() )
        {
            $codeBody = <<<EOD
$codeBody
    eventHandler.handle(new QueueEvent('%s', %s));
EOD;

            $codeBody = sprintf( $codeBody, $this->getQueue()->getType(), Core::createJson( $this->getQueue() ) );
        }

        // Create Javascript code
        $code = <<<EOD
var eventHandler, view, controller;
$(document).ready(function() {
	%s
} );
EOD;

        // Add javascript code
        $this->addJavascriptCode( sprintf( $code, $codeBody ) );

    }

    /**
     * @see Controller::request()
     */
    public function request()
    {

        // Get next Queue
        $this->setQueue( $this->getQueueDao()->getNext( self::$QUEUE_TYPES ) );

    }

    // /FUNCTIONS


}

?>