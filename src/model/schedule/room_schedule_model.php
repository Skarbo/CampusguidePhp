<?php

class RoomScheduleModel extends TypeScheduleModel implements StandardModel
{

    // VARIABLES


    private $id;
    private $elementId;
    private $updated;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getElementId()
    {
        return $this->elementId;
    }

    public function setElementId( $elementId )
    {
        $this->elementId = $elementId;
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

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getUpdated(), $this->getRegistered() );
    }

    // ... STATIC


    /**
     * @param RoomScheduleModel $get
     * @return RoomScheduleModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>