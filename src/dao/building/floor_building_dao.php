<?php

abstract class FloorBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $id
     * @return FloorBuildingModel
     * @see StandardDao::get()
     */
    public function get( $id )
    {
        return parent::get( $id );
    }

    /**
     * @return FloorBuildingListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @param array $foreignIds
     * @return FloorBuildingListModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return parent::getForeign( $foreignIds );
    }

    /**
     * @param array $ids
     * @return FloorBuildingListModel
     * @see StandardDao::getList()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    // /FUNCTIONS


}

?>