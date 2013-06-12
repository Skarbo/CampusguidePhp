<?php

class NavigateRestView extends AbstractRestView
{

    // VARIABLES


    public static $FIELD_NAVIGATE = "navigate";
    public static $FIELD_INFO = "info";
    public static $FIELD_INFO_POSITION = "position";
    public static $FIELD_INFO_FLOOR = "floor";
    public static $FIELD_INFO_ELEMENT = "element";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractView::getController()
     * @return NavigateRestController
     */
    public function getController()
    {
        return parent::getController();
    }

    // ... /GET


    /**
     * @see AbstractView::isNoCache()
     */
    protected function isNoCache()
    {
        return true;
    }

    /**
     * @see AbstractRestView::getData()
     */
    public function getData()
    {

        $data = array ();

        $data[ self::$FIELD_NAVIGATE ] = $this->getController()->getNavigatePath();

        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_ELEMENT ] = $this->getController()->getElement()->getId();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_FLOOR ] = $this->getController()->getFloor()->getId();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_POSITION ] = $this->getController()->getPosition();

        return $data;

    }

    // /FUNCTIONS


}

?>