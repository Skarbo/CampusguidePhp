<?php

class ElementBuildingListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $floorId
     * @param boolean $deleted True includes deleted Elements
     * @return ElementBuildingListModel
     */
    public function getFloor( $floorId, $deleted = false )
    {
        return $this->filter(
                function ( ElementBuildingModel $model ) use($floorId, $deleted )
                {
                    return $model->getFloorId() == $floorId && (!$deleted ? !$model->getDeleted() : true);
                } );
    }

    /**
     * @see IteratorCore::get()
     * @return ElementBuildingModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return ElementBuildingModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return ElementBuildingModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param ElementBuildingListModel $get
     * @return ElementBuildingListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>