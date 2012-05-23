<?php

class FacilityListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see IteratorCore::get()
     * @return FacilityModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return FacilityModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return FacilityModel
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @see IteratorCore::getId()
     * @return FacilityModel
     */
    public function getId( $id )
    {
        return parent::getId( $id );
    }

    // ... STATIC


    /**
     * @param FacilityListModel $get
     * @return FacilityListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>