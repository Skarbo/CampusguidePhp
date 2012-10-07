<?php

class SearchRestView extends AbstractRestView
{

    // VARIABLES


    public static $FIELD_FACILITIES = "facilities";
    public static $FIELD_BUILDINGS = "buildings";
    public static $FIELD_ELEMENTS = "elements";
    private static $FIELD_INFO = "info";
    private static $FIELD_INFO_LASTMODIFIED = "lastmodifed";
    private static $FIELD_INFO_SEARCH = "search";
    private static $FIELD_INFO_SIMPLE = "simple";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractView::getController()
     * @return SearchRestController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @see AbstractView::getLastModified()
     */
    protected function getLastModified()
    {
        return max( $this->getController()->getLastModified(), parent::getLastModified(), filemtime( __FILE__ ) );
    }

    // ... /GET


    /**
     * @see AbstractRestView::getData()
     */
    public function getData()
    {

        // Initiate data array
        $data = array ();

        // Simple
        if ( $this->getController()->isSimple() )
        {
            $data[ self::$FIELD_FACILITIES ] = $this->getController()->getFacilities()->getIds();
            $data[ self::$FIELD_BUILDINGS ] = $this->getController()->getBuildings()->getIds();
            $data[ self::$FIELD_ELEMENTS ] = $this->getController()->getElements()->getIds();
        }
        else
        {
            // Facilities
            $data[ self::$FIELD_FACILITIES ] = $this->getController()->getFacilities()->getJson();

            // Buildings
            $data[ self::$FIELD_BUILDINGS ] = $this->getController()->getBuildings()->getJson();

            // Buildings
            $data[ self::$FIELD_ELEMENTS ] = $this->getController()->getElements()->getJson();
        }

        // Info
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_LASTMODIFIED ] = gmdate( 'D, d M Y H:i:s \G\M\T',
                $this->getLastModified() );
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_SEARCH ] = SearchRestController::getSearchUri();
        $data[ self::$FIELD_INFO ][ self::$FIELD_INFO_SIMPLE ] = $this->getController()->isSimple();

        // Return data
        return $data;

    }

    // /FUNCTIONS


}

?>