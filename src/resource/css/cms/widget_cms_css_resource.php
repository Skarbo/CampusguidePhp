<?php

class WidgetCmsCssResource extends ClassCore
{

    private static $OVERLAYBACKGROUND;

    public $widget = "widget";

    /**
     * @return OverlaybackgroundWidgetCmsCssResource
     */
    public function overlaybackground()
    {
        self::$OVERLAYBACKGROUND = self::$OVERLAYBACKGROUND ? self::$OVERLAYBACKGROUND : new OverlaybackgroundWidgetCmsCssResource();
        return self::$OVERLAYBACKGROUND;
    }

}

?>