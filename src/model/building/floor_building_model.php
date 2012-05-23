<?php

class FloorBuildingModel extends Model implements StandardModel
{

    // VARIABLES


    public $id;
    public $buildingId;
    public $name;
    public $coordinates;
    public $order;
    public $main;
    public $updated;
    public $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return $this->getBuildingId();
    }

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getUpdated(), $this->getRegistered() );
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getBuildingId()
    {
        return $this->buildingId;
    }

    public function setBuildingId( $buildingId )
    {
        $this->buildingId = $buildingId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder( $order )
    {
        $this->order = $order;
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

    // ... STATIC


    /**
     * @param FloorBuildingModel $get
     * @return FloorBuildingModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setCoordinates( $coordinates )
    {
        $this->coordinates = $coordinates;
    }

    public function getMain()
    {
        return $this->main;
    }

    public function setMain( $main )
    {
        $this->main = $main;
    }

}

?>