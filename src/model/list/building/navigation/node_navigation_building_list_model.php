<?php

class NodeNavigationBuildingListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return NodeNavigationBuildingModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return NodeNavigationBuildingModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return NodeNavigationBuildingModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param NodeNavigationBuildingListModel $get
     * @return NodeNavigationBuildingListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


// /FUNCTIONS


}

?>