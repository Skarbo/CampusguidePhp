<?php

interface FloorBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Set given Floor as main floor. Null if sets first Floor as main.
     *
     * @param int $buildingId
     * @param int $id Floor id, null sets first Floor as main
     * @return boolean True if success
     * @throws DbException
     */
    public function setMainFloor( $buildingId, $id );

    /**
     * Main floors for given Buildings
     *
     * @param array $buildingIds
     * @return FloorBuildingListModel
     */
    public function getMainFloors( array $buildingIds );

    // /FUNCTIONS


}

?>