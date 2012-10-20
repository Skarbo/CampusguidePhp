<?php

class LogModel extends Model implements StandardModel
{

    // VARIABLES

    const TYPE_SCHEDULE_TYPE = "schedule_type";
    const TYPE_SCHEDULE_ENTIRES = "schedule_entires";
    const TYPE_SCHEDULE_ENTIRES_TOOMANYWEEKS = "schedule_entires_toomanyweeks";

    private $id;
    private $type;
    private $text;
    private $websiteId;
    private $scheduleType;
    private $updated;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

	/**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText( $text )
    {
        $this->text = $text;
    }

    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    public function setWebsiteId( $websiteId )
    {
        $this->websiteId = $websiteId;
    }

    public function getScheduleType()
    {
        return $this->scheduleType;
    }

    public function setScheduleType( $scheduleType )
    {
        $this->scheduleType = $scheduleType;
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
    	return null;
    }

	// ... STATIC

	/**
     * @param LogModel $get
     * @return LogModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

	// ... /STATIC

    // /FUNCTIONS

}

?>