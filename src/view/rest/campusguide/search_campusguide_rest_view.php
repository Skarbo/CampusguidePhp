<?php

class SearchCampusguideRestView extends RestView
{

    // VARIABLES


    public static $FIELD_FACILITIES = "facilities";
    public static $FIELD_BUILDINGS = "buildings";
    private static $FIELD_INFO = "info";
    private static $FIELD_INFO_LASTMODIFIED = "lastmodifed";
    private static $FIELD_INFO_SEARCH = "search";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see View::getController()
     * @return SearchCampusguideRestController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see View::getLastModified()
     */
    protected function getLastModified()
    {
        return max( $this->getController()->getLastModified(), parent::getLastModified(), filemtime( __FILE__ ) );
    }

    // ... /GET


    /**
     * @see RestView::getData()
     */
    public function getData()
    {

        // Initiate data array
        $data = array ();

        // Facilities
        $data[ self::$FIELD_FACILITIES ] = $this->getController()->getFacilities();

        // Buildings
        $data[ self::$FIELD_BUILDINGS ] = $this->getController()->getBuildings();

        // Info
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_LASTMODIFIED ] = gmdate( 'D, d M Y H:i:s \G\M\T',
                $this->getLastModified() );
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_SEARCH ] = SearchCampusguideRestController::getSearchString();

        // Return data
        return $data;

    }

    // /FUNCTIONS


}

?>