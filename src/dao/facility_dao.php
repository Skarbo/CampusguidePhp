<?php

abstract class FacilityDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Get Facility
     *
     * @return FacilityModel
     * @see StandardDao::get()
     */
    public function get( $facilityId )
    {
        return parent::get( $facilityId );
    }

    /**
     * Get all Facilities
     *
     * @return FacilityListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * Get given Facilities
     *
     * @return FacilityListModel
     * @see StandardDao::getForeign()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    /**
     * @return FacilityListModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return $this->getAll();
    }

    /**
     * Add Facility
     *
     * @return int Facility id
     * @see StandardDao::add();
     */
    public function add( StandardModel $model, $foreignId )
    {
        return parent::add( $model, $foreignId );
    }

    /**
     * Edit Facility
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
     * @return int Number of removed Facility
     * @see StandardDao::removeAll();
     */
    public function removeAll()
    {
        return parent::removeAll();
    }

    /**
     * Remove Facility
     *
     * @return boolean True if Facility removed
     * @see StandardDao::remove();
     */
    public function remove( $id )
    {
        return parent::remove( $id );
    }

    // /FUNCTIONS


}

?>