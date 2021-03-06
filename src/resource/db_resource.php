<?php

class DbResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $ELEMENTBUILDING, $TYPEELEMENTBUILDING, $GROUPTYPEELEMENTBUILDING, $FLOORBUILDING, $SECTIONBUILDING, $FACILITY, $QUEUE, $LOG;
    private static $ENTRYSCHEDULE, $OCCURENCEENTRYSCHEDULE, $FACULTYSCHEDULE, $GROUPSCHEDULE, $PROGRAMSCHEDULE, $ROOMSCHEDULE, $WEBSITESCHEDULE;
    private static $EDGENAVIGATIONBUILDING, $NODENAVIGATIONBUILDING;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BuildingDbResource
     */
    public static function building()
    {
        self::$BUILDING = self::$BUILDING ? self::$BUILDING : new BuildingDbResource();
        return self::$BUILDING;
    }

    /**
     * @return ElementBuildingDbResource
     */
    public static function elementBuilding()
    {
        self::$ELEMENTBUILDING = self::$ELEMENTBUILDING ? self::$ELEMENTBUILDING : new ElementBuildingDbResource();
        return self::$ELEMENTBUILDING;
    }

    /**
     * @return FloorBuildingDbResource
     */
    public static function floorBuilding()
    {
        self::$FLOORBUILDING = self::$FLOORBUILDING ? self::$FLOORBUILDING : new FloorBuildingDbResource();
        return self::$FLOORBUILDING;
    }

    /**
     * @return SectionBuildingDbResource
     */
    public static function sectionBuilding()
    {
        self::$SECTIONBUILDING = self::$SECTIONBUILDING ? self::$SECTIONBUILDING : new SectionBuildingDbResource();
        return self::$SECTIONBUILDING;
    }

    /**
     * @return FacilityDbResource
     */
    public static function facility()
    {
        self::$FACILITY = self::$FACILITY ? self::$FACILITY : new FacilityDbResource();
        return self::$FACILITY;
    }

    /**
     * @return QueueDbResource
     */
    public function queue()
    {
        self::$QUEUE = self::$QUEUE ? self::$QUEUE : new QueueDbResource();
        return self::$QUEUE;
    }

    /**
     * @return EntryScheduleDbResource
     */
    public static function entrySchedule()
    {
        self::$ENTRYSCHEDULE = self::$ENTRYSCHEDULE ? self::$ENTRYSCHEDULE : new EntryScheduleDbResource();
        return self::$ENTRYSCHEDULE;
    }

    /**
     * @return FacultyScheduleDbResource
     */
    public static function facultySchedule()
    {
        self::$FACULTYSCHEDULE = self::$FACULTYSCHEDULE ? self::$FACULTYSCHEDULE : new FacultyScheduleDbResource();
        return self::$FACULTYSCHEDULE;
    }

    /**
     * @return GroupScheduleDbResource
     */
    public static function groupSchedule()
    {
        self::$GROUPSCHEDULE = self::$GROUPSCHEDULE ? self::$GROUPSCHEDULE : new GroupScheduleDbResource();
        return self::$GROUPSCHEDULE;
    }

    /**
     * @return ProgramScheduleDbResource
     */
    public static function programSchedule()
    {
        self::$PROGRAMSCHEDULE = self::$PROGRAMSCHEDULE ? self::$PROGRAMSCHEDULE : new ProgramScheduleDbResource();
        return self::$PROGRAMSCHEDULE;
    }

    /**
     * @return RoomScheduleDbResource
     */
    public static function roomSchedule()
    {
        self::$ROOMSCHEDULE = self::$ROOMSCHEDULE ? self::$ROOMSCHEDULE : new RoomScheduleDbResource();
        return self::$ROOMSCHEDULE;
    }

    /**
     * @return WebsiteScheduleDbResource
     */
    public static function websiteSchedule()
    {
        self::$WEBSITESCHEDULE = self::$WEBSITESCHEDULE ? self::$WEBSITESCHEDULE : new WebsiteScheduleDbResource();
        return self::$WEBSITESCHEDULE;
    }

    /**
     * @return LogDbResource
     */
    public static function log()
    {
        self::$LOG = self::$LOG ? self::$LOG : new LogDbResource();
        return self::$LOG;
    }

    /**
     * @return EdgeNavigationBuildingDbResource
     */
    public static function edgeNavigationBuilding()
    {
        self::$EDGENAVIGATIONBUILDING = self::$EDGENAVIGATIONBUILDING ? self::$EDGENAVIGATIONBUILDING : new EdgeNavigationBuildingDbResource();
        return self::$EDGENAVIGATIONBUILDING;
    }

    /**
     * @return NodeNavigationBuildingDbResource
     */
    public static function nodeNavigationBuilding()
    {
        self::$NODENAVIGATIONBUILDING = self::$NODENAVIGATIONBUILDING ? self::$NODENAVIGATIONBUILDING : new NodeNavigationBuildingDbResource();
        return self::$NODENAVIGATIONBUILDING;
    }

    // /FUNCTIONS


}

?>