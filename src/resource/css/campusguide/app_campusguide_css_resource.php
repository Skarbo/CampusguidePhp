<?php

class AppCampusguideCssResource extends ClassCore
{

    // VARIABLES


    private static $MAP;

    private $tablet = "tablet";
    private $mobile = "mobile";
    private $desktop = "desktop";

    private $overlayWrapper = "overlay_wrapper";
    private $overlay = "overlay";
    private $overlayTitle = "title";
    private $overlayBody = "body";

    private $overlayMenu = "menu";

    private $touch = "hover";

    private $button = "button";

    private $error = "error";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return MapAppCampusguideCssResource
     */
    public function map()
    {
        self::$MAP = self::$MAP ? self::$MAP : new MapAppCampusguideCssResource();
        return self::$MAP;
    }

    // /FUNCTIONS


    public function getTablet()
    {
        return $this->tablet;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function getDesktop()
    {
        return $this->desktop;
    }

    public function getOverlayWrapper()
    {
        return $this->overlayWrapper;
    }

    public function getOverlay()
    {
        return $this->overlay;
    }

    public function getOverlayTitle()
    {
        return $this->overlayTitle;
    }

    public function getOverlayBody()
    {
        return $this->overlayBody;
    }

    public function getOverlayMenu()
    {
        return $this->overlayMenu;
    }

    public function getTouch()
    {
        return $this->touch;
    }

    public function getButton()
    {
        return $this->button;
    }

    public function getError()
    {
        return $this->error;
    }

}

?>