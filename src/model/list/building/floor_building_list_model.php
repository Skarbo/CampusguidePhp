<?php

class FloorBuildingListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return number Next order in list
     */
    public function getNextOrder()
    {
        $orderLargest = -1;
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $floor = $this->current();
            $orderLargest = $floor->getOrder() > $orderLargest ? $floor->getOrder() : $orderLargest;
        }
        return $orderLargest + 1;
    }

    /**
     * Sort list by Order
     */
    public function sortByOrder()
    {
        usort($this->getArray(), function( FloorBuildingModel $floorLeft, FloorBuildingModel $floorRight ){
            return $floorLeft->getOrder() == $floorRight->getOrder() ? 0 : ( $floorLeft->getOrder() < $floorRight->getOrder() ? -1 : 1 );
        });
    }

    /**
     * @see IteratorCore::get()
     * @return FloorBuildingModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return FloorBuildingModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return FloorBuildingModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param FloorBuildingListModel $get
     * @return FloorBuildingListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>