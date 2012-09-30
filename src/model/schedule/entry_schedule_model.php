<?php

class EntryScheduleModel extends AbstractWebsiteScheduleModel implements StandardModel
{

    // VARIABLES


    private $id;
    private $type;
    private $timeStart;
    private $timeEnd;
    private $updated;
    private $registered;

    /**
     * @var array
     */
    private $occurences = array ();
    /**
     * @var FacultyScheduleListModel
     */
    private $faculties;
    /**
     * @var GroupScheduleListModel
     */
    private $groups;
    /**
     * @var ProgramScheduleListModel
     */
    private $programs;
    /**
     * @var RoomScheduleListModel
     */
    private $rooms;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $a = array() )
    {
        parent::__construct( $a );

        $this->setFaculties( new FacultyScheduleListModel() );
        $this->setGroups( new GroupScheduleListModel() );
        $this->setPrograms( new ProgramScheduleListModel() );
        $this->setRooms( new RoomScheduleListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return array
     */
    public function getOccurences()
    {
        return $this->occurences;
    }

    /**
     * @param array $occurences
     */
    public function setOccurences( array $occurences )
    {
        $this->occurences = $occurences;
    }

    /**
     * @return FacultyScheduleListModel
     */
    public function getFaculties()
    {
        return $this->faculties;
    }

    /**
     * @param FacultyScheduleListModel $faculties
     */
    public function setFaculties( FacultyScheduleListModel $faculties )
    {
        $this->faculties = $faculties;
    }

    /**
     * @return GroupScheduleListModel
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param GroupScheduleListModel $groups
     */
    public function setGroups( GroupScheduleListModel $groups )
    {
        $this->groups = $groups;
    }

    /**
     * @return ProgramScheduleListModel
     */
    public function getPrograms()
    {
        return $this->programs;
    }

    /**
     * @param ProgramScheduleListModel $programs
     */
    public function setPrograms( ProgramScheduleListModel $programs )
    {
        $this->programs = $programs;
    }

    /**
     * @return RoomScheduleListModel
     */
    public function getRooms()
    {
        return $this->rooms;
    }

    /**
     * @param RoomScheduleListModel $rooms
     */
    public function setRooms( RoomScheduleListModel $rooms )
    {
        $this->rooms = $rooms;
    }

    // ... /GETTERS/SETTERS


    // ... GET


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

    public function getTimeStart()
    {
        return $this->timeStart;
    }

    public function setTimeStart( $timeStart )
    {
        $this->timeStart = $timeStart;
    }

    public function getTimeEnd()
    {
        return $this->timeEnd;
    }

    public function setTimeEnd( $timeEnd )
    {
        $this->timeEnd = $timeEnd;
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

    // ... /GET


    public function addOccurence( $occurence )
    {
        if ( !in_array( $occurence, $this->getOccurences() ) )
            $this->occurences[] = $occurence;
        sort( $this->occurences );
    }

    /**
     * Merges Entry
     *
     * @param EntryScheduleModel $entry
     */
    public function merge( EntryScheduleModel $entry )
    {
        $this->occurences = array_unique( array_merge( $this->getOccurences(), $entry->getOccurences() ) );
        sort( $this->occurences );
    }

    /**
     * @param EntryScheduleModel $entry
     * @return boolean True if equal
     */
    public function isEqual( EntryScheduleModel $entry )
    {
        if ( !$entry )
            return false;
        if ( date( "H:i", $entry->getTimeStart() ) != date( "H:i", $this->getTimeStart() ) || date( "H:i",
                $entry->getTimeEnd() ) != date( "H:i", $this->getTimeEnd() ) )
            return false;
        if ( strcasecmp( $this->getType(), $entry->getType() ) != 0 )
            return false;
        if ( !$this->getFaculties()->isEqual( $entry->getFaculties() ) )
            return false;
        if ( !$this->getPrograms()->isEqual( $entry->getPrograms() ) )
            return false;
        if ( !$this->getRooms()->isEqual( $entry->getRooms() ) )
            return false;
        if ( !$this->getGroups()->isEqual( $entry->getGroups() ) )
            return false;
        return true;
    }

    // ... STATIC


    /**
     * @param EntryScheduleModel $get
     * @return EntryScheduleModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>