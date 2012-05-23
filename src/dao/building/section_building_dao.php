<?php

abstract class SectionBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return SectionBuildingModel
     * @see StandardDao::get()
     */
    public function get( $id )
    {
        return parent::get( $id );
    }

    /**
     * @return SectionBuildingListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @return SectionBuildingListModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return parent::getForeign( $foreignIds );
    }

    /**
     * @return SectionBuildingListModel
     * @see StandardDao::getList()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    // /FUNCTIONS


}

?>