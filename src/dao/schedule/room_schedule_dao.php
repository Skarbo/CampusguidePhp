<?php

interface RoomScheduleDao extends TypeScheduleDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS



    /**
     * Merge Rooms with similar Elements
     */
    public function mergeElements();

    /**
     * Rooms for given floor
     *
     * @param integer $floorId
     * @return RoomScheduleListModel
     */
    public function getFloor($floorId);

    // /FUNCTIONS


}

?>