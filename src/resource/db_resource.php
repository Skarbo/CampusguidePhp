<?php

class DbResource extends ClassCore
{

    // VARIABLES


    private static $BUILDING, $ELEMENTBUILDING, $TYPEELEMENTBUILDING, $GROUPTYPEELEMENTBUILDING, $FLOORBUILDING, $SECTIONBUILDING, $FACILITY, $QUEUE;

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
     * @return TypeElementBuildingDbResource
     */
    public static function typeElementBuilding()
    {
        self::$TYPEELEMENTBUILDING = self::$TYPEELEMENTBUILDING ? self::$TYPEELEMENTBUILDING : new TypeElementBuildingDbResource();
        return self::$TYPEELEMENTBUILDING;
    }

    /**
     * @return GroupTypeElementBuildingDbResource
     */
    public static function groupTypeElementBuilding()
    {
        self::$GROUPTYPEELEMENTBUILDING = self::$GROUPTYPEELEMENTBUILDING ? self::$GROUPTYPEELEMENTBUILDING : new GroupTypeElementBuildingDbResource();
        return self::$GROUPTYPEELEMENTBUILDING;
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

    // /FUNCTIONS


}

?>