<?php

class GroupScheduleModel extends TypeScheduleModel implements StandardModel
{

    // VARIABLES

    private $id;
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
     * @param GroupScheduleModel $get
     * @return GroupScheduleModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

	// ... /STATIC

    // /FUNCTIONS

}

?>