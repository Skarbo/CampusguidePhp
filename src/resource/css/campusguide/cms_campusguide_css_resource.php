<?php

class CmsCampusguideCssResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $FACILITY, $MENU, $PAGE;

    private $error = "error";
    private $success = "success";
    private $fieldsWrapper = "fields_wrapper";
    private $fields = "fields";
    private $required = "required";
    private $light = "light";
    private $hide = "hide";
    private $inactive = "inactive";

    private $overlayWrapper = "overlay_wrapper";
    private $overlay = "overlay";
    private $overlayTitle = "title";
    private $overlayBody = "body";
    private $overlayButtons = "buttons";
    private $overlayButtonsCancel = "cancel";
    private $overlayButtonsOk = "ok";

    private $button = "cms_button";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BuildingCmsCampusguideCssResource
     */
    public function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingCmsCampusguideCssResource();
        return self::$BUILDING;
    }

    /**
     * @return FacilityCmsCampusguideCssResource
     */
    public function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityCmsCampusguideCssResource();
        return self::$FACILITY;
    }

    /**
     * @return MenuCmsCampusguideCssResource
     */
    public function menu()
    {
        self::$MENU = self::$MENU ? self::$MENU : new MenuCmsCampusguideCssResource();
        return self::$MENU;
    }

    /**
     * @return PageCmsCampusguideCssResource
     */
    public function page()
    {
        self::$PAGE = self::$PAGE ? self::$PAGE : new PageCmsCampusguideCssResource();
        return self::$PAGE;
    }

    // /FUNCTIONS


    public function getError()
    {
        return $this->error;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function getLight()
    {
        return $this->light;
    }

    public function getOverlay()
    {
        return $this->overlay;
    }

    public function getHide()
    {
        return $this->hide;
    }

    public function getInactive()
    {
        return $this->inactive;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function getFieldsWrapper()
    {
        return $this->fieldsWrapper;
    }

    public function getOverlayWrapper()
    {
        return $this->overlayWrapper;
    }

    public function getOverlayTitle()
    {
        return $this->overlayTitle;
    }

    public function getOverlayBody()
    {
        return $this->overlayBody;
    }

    public function getOverlayButtonsCancel()
    {
        return $this->overlayButtonsCancel;
    }

    public function getOverlayButtonsOk()
    {
        return $this->overlayButtonsOk;
    }

    public function getOverlayButtons()
    {
        return $this->overlayButtons;
    }

    public function getButton()
    {
        return $this->button;
    }

}

?>