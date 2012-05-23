<?php

abstract class BuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Get Building
     *
     * @return BuildingModel
     * @see StandardDao::get()
     */
    public function get( $buildingId )
    {
        return parent::get( $buildingId );
    }

    /**
     * Get all Facilities
     *
     * @return BuildingListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * Get given Facilities
     *
     * @return BuildingListModel
     * @see StandardDao::getForeign()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    /**
     * @return BuildingListModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return parent::getForeign( $foreignIds );
    }

    /**
     * Add Building
     *
     * @return int Building id
     * @see StandardDao::add();
     */
    public function add( StandardModel $model, $foreignId )
    {
        return parent::add( $model, $foreignId );
    }

    /**
     * Edit Building
     *
     * @return boolean True if updated
     * @see StandardDao::edit();
     */
    public function edit( $id, StandardModel $model, $foreignId )
    {
        return parent::edit( $id, $model, $foreignId );
    }

    /**
     * Remove all Facilities
     *
     * @return int Number of removed Building
     * @see StandardDao::removeAll();
     */
    public function removeAll()
    {
        return parent::removeAll();
    }

    /**
     * Remove Building
     *
     * @return boolean True if Building removed
     * @see StandardDao::remove();
     */
    public function remove( $id )
    {
        return parent::remove( $id );
    }

    // /FUNCTIONS


}

?>