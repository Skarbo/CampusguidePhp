<?php

class BuildingListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return BuildingModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return BuildingModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return BuildingModel
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @see IteratorCore::getId()
     * @return BuildingModel
     */
    public function getId( $id )
    {
        return parent::getId( $id );
    }

    /**
     * @param array $facilityIds
     * @return BuildingListModel
     */
    public function getFacilities( array $facilityIds )
    {
        return $this->filter(
                function ( BuildingModel $building ) use($facilityIds )
                {
                    return in_array( $building->getFacilityId(), $facilityIds );
                } );
    }

    // ... STATIC


    /**
     * @param BuildingListModel $get
     * @return BuildingListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>