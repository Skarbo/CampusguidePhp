<?php

class ScheduleDefaultLocale extends Locale
{

    // VARIABLES


    protected $faculty = "Faculty";
    protected $room = "Room";
    protected $group = "Group";
    protected $program = "Program";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getType( $type )
    {
        switch ( $type )
        {
            case TypeScheduleModel::TYPE_FACULTY :
                return $this->faculty;
            case TypeScheduleModel::TYPE_ROOM :
                return $this->room;
            case TypeScheduleModel::TYPE_GROUP :
                return $this->group;
            case TypeScheduleModel::TYPE_PROGRAM :
                return $this->program;
        }
        return $type;
    }

    // /FUNCTIONS


}

?>