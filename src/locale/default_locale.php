<?php

class DefaultLocale extends AbstractDefaultLocale
{

    // VARIABLES


    private static $_BUILDING, $_FACILITY, $_SCHEDULE;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return BuildingDefaultLocale
     */
    public function building()
    {
        self::$_BUILDING = self::$_BUILDING ? self::$_BUILDING : new BuildingDefaultLocale();
        return self::$_BUILDING;
    }

    /**
     * @return FacilityDefaultLocale
     */
    public function facility()
    {
        self::$_FACILITY = self::$_FACILITY ? self::$_FACILITY : $this->getLocaleClass(
                FacilityDefaultLocale::class_() );
        return self::$_FACILITY;
    }

    /**
     * @return ScheduleDefaultLocale
     */
    public function schedule()
    {
        self::$_SCHEDULE = self::$_SCHEDULE ? self::$_SCHEDULE : $this->getLocaleClass(
                ScheduleDefaultLocale::class_() );
        return self::$_SCHEDULE;
    }

    // /FUNCTIONS


}

?>