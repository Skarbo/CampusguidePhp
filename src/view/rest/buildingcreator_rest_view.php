<?php

class BuildingcreatorRestView extends AbstractRestView
{

    // VARIABLES


    public static $FIELD_BUILDING = "building";
    public static $FIELD_FLOORS = "floors";
    public static $FIELD_ELEMENTS = "elements";
    public static $FIELD_NAVIGATIONS = "navigations";
    public static $FIELD_INFO = "info";
    public static $FIELD_INFO_BUILDING = "building";
    public static $FIELD_INFO_FLOORS = "floors";
    public static $FIELD_INFO_TYPES = "types";
    public static $FIELD_INFO_LASTMODIFIED = "lastmodified";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractRestView::getLastModified()
     */
    protected function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified(), $this->getController()->getLastModified() );
    }

    /**
     * @see AbstractView::getController()
     * @return BuildingcreatorRestController
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
        return false;
    }

    /**
     * @see AbstractRestView::getData()
     */
    public function getData()
    {
        $data = array ();

        $data[ self::$FIELD_BUILDING ] = $this->getController()->getBuildingContainer()->getBuilding();
        $data[ self::$FIELD_ELEMENTS ] = $this->getController()->getBuildingContainer()->getElements()->getJson();
        $data[ self::$FIELD_FLOORS ] = $this->getController()->getBuildingContainer()->getFloors()->getJson();
        $data[ self::$FIELD_NAVIGATIONS ] = $this->getController()->getBuildingContainer()->getNavigations()->getJson();

        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_LASTMODIFIED ] = $this->getLastModified();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_BUILDING ] = $this->getController()->getBuildingContainer()->getBuilding()->getId();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_FLOORS ] = $this->getController()->getBuildingContainer()->getFloors()->getIds();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_TYPES ] = $this->getController()->getTypesUri();

        return $data;
    }

    // /FUNCTIONS


}

?>