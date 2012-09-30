<?php

class FacultyScheduleModel extends TypeScheduleModel implements StandardModel
{

    // VARIABLES


    private $id;
    private $roomId;
    private $type;
    private $phone;
    private $email;
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone( $phone )
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail( $email )
    {
        $this->email = $email;
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

    public function getRoomId()
    {
        return $this->roomId;
    }

    public function setRoomId( $roomId )
    {
        $this->roomId = $roomId;
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
     * @param FacultyScheduleModel $get
     * @return FacultyScheduleModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>