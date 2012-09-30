<?php

class WebsiteScheduleListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return WebsiteScheduleModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return WebsiteScheduleModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return WebsiteScheduleModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param WebsiteScheduleListModel $get
     * @return WebsiteScheduleListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


// /FUNCTIONS


}

?>