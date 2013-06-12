<?php

abstract class AppMainController extends MainController
{

    // VARIABLES


    const URI_ID = 1;

    /**
     * @var MobiledetectApi
     */
    private $mobiledetectApi;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

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

    // ... ... /STATIC


    /**
     * @see AbstractMainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "%s - %s", "Application", parent::getTitle() );
    }

    /**
     * @see MainController::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see AbstractController::getLocale()
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


//     protected function addJavascriptMap()
//     {

//         $code = <<<EOD
// $(document).ready(function() {
// 	var script = document.createElement("script");
//     script.type = "text/javascript";
//     script.src = "%s";
//     document.body.appendChild(script);
// } );

// function initMap()
// {
//     eventHandler.handle(new MapinitEvent());
// }
// EOD;

//         $this->addJavascriptCode(
//                 sprintf( $code, Resource::javascript()->getGoogleMapsApiUrl( Resource::getGoogleApiKey(), "initMap" ) ) );

//     }

    // ... /ADD


    /**
     * @see AbstractMainController::after()
     */
    public function after()
    {
        parent::after();

        // Add Javascript files
        $this->addJavascriptFile( Resource::javascript()->getJqueryApiFile() );
        //$this->addJavascriptFile( Resource::javascript()->getJqueryDragApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJqueryHistoryApiFile() );
        $this->addJavascriptFile( Resource::javascript()->getJavascriptAppFile( $this->getMode() ) );
        $this->addJavascriptFile( Resource::javascript()->getKineticApiFile() );

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
                json_encode( array ( "id" => self::getId() ) ) );

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