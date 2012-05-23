<?php

abstract class AppCampusguideMainController extends CampusguideMainController
{

    // VARIABLES


    const URI_PAGE = 1;
    const URI_ID = 2;

    /**
     * @var MobiledetectApi
     */
    private $mobiledetectApi;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $db_api, AbstractDefaultLocale $locale, View $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );

        $this->setMobiledetectApi( new MobiledetectApi() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return MobiledetectApi
     */
    public function getMobiledetectApi()
    {
        return $this->mobiledetectApi;
    }

    /**
     * @param MobiledetectApi $mobiledetectApi
     */
    private function setMobiledetectApi( MobiledetectApi $mobiledetectApi )
    {
        $this->mobiledetectApi = $mobiledetectApi;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    // ... ... STATIC


    /**
     * @return int Id given in URI, 0 if none given
     */
    protected static function getId()
    {
        return intval( self::getURI( self::URI_ID, 0 ) );
    }

    /**
     * @return string Page given i URI, null if none given
     */
    protected static function getPage()
    {
        return self::getURI( self::URI_PAGE );
    }

    // ... ... /STATIC


    /**
     * @see MainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "%s - %s", "Application", parent::getTitle() );
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

    // ... /ADD


    /**
     * @see MainController::after()
     */
    public function after()
    {
        parent::after();

        // Add Javascript files
        $this->addJavascriptFile( Resource::javascript()->getJqueryApiFile() );
        //$this->addJavascriptFile( Resource::javascript()->getJqueryDragApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryHistoryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJavascriptAppFile( $this->getMode() ) );

        // Add CSS files
        $this->addCssFile( Resource::css()->getCssAppFile() );

        // Create Javascript code
        $code = <<<EOD
var eventHandler, view, controller;
$(document).ready(function() {
    eventHandler = new EventHandler();
    view = new %s("%s");
    controller = new %s(eventHandler, %d, %s);
    controller.render(view);
} );
EOD;

        $code = sprintf( $code, $this->getJavascriptView(), $this->getViewWrapperId(),
                $this->getJavascriptController(), $this->getMode(),
                json_encode( array ( "page" => self::getPage(), "id" => self::getId() ) ) );

        // Add javascript code
        $this->addJavascriptCode( $code );

        // Add meta tags
        if ( $this->getMobiledetectApi()->isMobile() || $this->getMobiledetectApi()->isTablet() )
        {
            $this->addMetaTag(
                    Xhtml::meta()->name( MetaXhtml::$NAME_VIEWPORT )->content(
                            implode( ",",
                                    array ( MetaXhtml::$CONTENT_VIEWPORT_MAXSCALE_1,
                                            MetaXhtml::$CONTENT_VIEWPORT_MINCALE_1,
                                            MetaXhtml::$CONTENT_VIEWPORT_USERSCALABLE_NO,
                                            MetaXhtml::$CONTENT_VIEWPORT_WIDTH_DEVICEWIDTH ) ) ) );
        }

    }

    // /FUNCTIONS


}

?>