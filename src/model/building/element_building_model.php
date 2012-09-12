<?php

class ElementBuildingModel extends Model implements StandardModel
{

    // VARIABLES


    public $id;
    public $sectionId;
    public $typeId;
    public $floorId;
    public $name;
    public $coordinates;
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
        return $this->getFloorId();
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

    public function getSectionId()
    {
        return $this->sectionId;
    }

    public function setSectionId( $sectionId )
    {
        $this->sectionId = $sectionId;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setTypeId( $typeId )
    {
        $this->typeId = $typeId;
    }

    public function getFloorId()
    {
        return $this->floorId;
    }

    public function setFloorId( $floorId )
    {
        $this->floorId = $floorId;
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

    // ... STATIC


    /**
     * @param ElementBuildingModel $get
     * @return ElementBuildingModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>