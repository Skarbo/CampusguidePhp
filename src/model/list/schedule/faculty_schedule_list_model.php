<?php

class FacultyScheduleListModel extends TypeScheduleListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getType()
    {
        return FacultyScheduleModel::TYPE_FACULTY;
    }

    /**
     * @see IteratorCore::get()
     * @return FacultyScheduleModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return FacultyScheduleModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return FacultyScheduleModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param FacultyScheduleListModel $get
     * @return FacultyScheduleListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>