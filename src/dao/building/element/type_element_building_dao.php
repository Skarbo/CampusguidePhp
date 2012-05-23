<?php

abstract class TypeElementBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $id
     * @return TypeElementBuildingModel
     * @see StandardDao::get()
     */
    public function get( $id )
    {
        return parent::get( $id );
    }

    /**
     * @return TypeElementBuildingListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @param array $foreignIds
     * @return TypeElementBuildingListModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return $this->getAll();
    }

    /**
     * @param array $ids
     * @see StandardDao::getList()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    // /FUNCTIONS


}

?>