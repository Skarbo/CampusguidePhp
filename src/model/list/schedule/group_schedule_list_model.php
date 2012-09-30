<?php

class GroupScheduleListModel extends TypeScheduleListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return GroupScheduleModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return GroupScheduleModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return GroupScheduleModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param GroupScheduleListModel $get
     * @return GroupScheduleListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


// /FUNCTIONS


}

?>