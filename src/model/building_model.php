<?php

class BuildingModel extends Model implements StandardModel
{

    // VARIABLES


    public $id;
    public $facilityId;
    public $name;
    public $coordinates;
    public $address = array();
    public $location = array();
    public $position = array();
    public $updated;
    public $registered;

    public $floors;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... STATIC


    /**
     * @param BuildingModel $get
     * @return BuildingModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getRegistered(), $this->getUpdated() );
    }

    public function getForeignId()
    {
        return $this->getFacilityId();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getFacilityId()
    {
        return $this->facilityId;
    }

    public function setFacilityId( $facilityId )
    {
        $this->facilityId = $facilityId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates( $coordinates )
    {
        $this->coordinates = $coordinates;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated( $updated )
    {
        $this->updated = $updated;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function setRegistered( $registered )
    {
        $this->registered = $registered;
    }

    // /FUNCTIONS


    public function getPosition()
    {
        return $this->position;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setPosition( $location )
    {
        $this->position = $location;
    }

    public function setAddress( array $address )
    {
        $this->address = $address;
    }

    public function getFloors()
    {
        return $this->floors;
    }

    public function setFloors( $floors )
    {
        $this->floors = $floors;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation( $location )
    {
        $this->location = $location;
    }

}

?>