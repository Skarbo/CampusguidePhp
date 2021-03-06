<?php

class QueueModel extends Model
{

    // VARIABLES


    const TYPE_IMAGE_BUILDING = "building";
    const TYPE_SCHEDULE_TYPES = "schedule_types";
    const TYPE_SCHEDULE_ENTRIES = "schedule_entries";

    public static $TYPES = array ( self::TYPE_IMAGE_BUILDING, self::TYPE_SCHEDULE_TYPES, self::TYPE_SCHEDULE_ENTRIES );

    public static $ARGUMENT_SCHEDULE_TYPE_PAGE = "page";
    public static $ARGUMENT_SCHEDULE_TYPE_IDS = "types";
    public static $ARGUMENT_SCHEDULE_TYPE_WEEKS = "weeks";
    public static $ARGUMENT_SCHEDULE_TYPE_CODES_PR = "codes_pr";

    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;

    public static $PRIORITIES = array ( self::PRIORITY_LOW, self::PRIORITY_MEDIUM, self::PRIORITY_HIGH );

    public $id;
    public $type;
    public $priority;
    public $arguments;
    public $buildingId;
    public $websiteId;
    public $scheduleType;
    private $occurence;
    private $error;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function getBuildingId()
    {
        return $this->buildingId;
    }

    public function setBuildingId( $buildingId )
    {
        $this->buildingId = $buildingId;
    }

    public function getOccurence()
    {
        return $this->occurence;
    }

    public function setOccurence( $occurence )
    {
        $this->occurence = $occurence;
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
     * @param QueueModel $get
     * @return QueueModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


    public function getArguments()
    {
        return $this->arguments;
    }

    public function setArguments( $arguments )
    {
        $this->arguments = $arguments;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setPriority( $priority )
    {
        $this->priority = $priority;
    }

    public function setError( $error )
    {
        $this->error = $error;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated( $updated )
    {
        $this->updated = $updated;
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

}

?>