<?php

abstract class GroupTypeElementBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return GroupTypeElementBuildingModel
     * @see StandardDao::get()
     */
    public function get( $id )
    {
        return parent::get( $id );
    }

    /**
     * @return GroupTypeElementBuildingListModel
     * @see StandardDao::getAll()
     */
    public function getAll()
    {
        return parent::getAll();
    }

    /**
     * @return GroupTypeElementBuildingModel
     * @see StandardDao::getForeign()
     */
    public function getForeign( array $foreignIds )
    {
        return $this->getAll();
    }

    /**
     * @return GroupTypeElementBuildingListModel
     * @see StandardDao::getList()
     */
    public function getList( array $ids )
    {
        return parent::getList( $ids );
    }

    // /FUNCTIONS


}

?>