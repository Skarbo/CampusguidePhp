<?php

class FacilityCmsCssResource extends ClassCore
{

    // VARIABLES


    private $facilities = "facilities";
    private $facilitiesTableBody = "facilities_table_body";
    private $facility = "facility";

    private $facilityBuildings = "facility_buildings";
    private $facilityBuildingsWrapper = "facility_buildings_wrapper";
    private $facilityBuildingsTable = "facility_buildings_table";
    private $facilityBuildingsBuildingWrapper = "facility_buildings_building_wrapper";
    private $facilityBuildingsBuildingTable = "facility_buildings_building_table";
    private $facilityBuildingsBuildingContent = "facility_buildings_building_content";

    private $check = "check";
    private $map = "map";
    private $name = "name";
    private $buildings = "buildings";
    private $registered = "registered";
    private $updated = "updated";
    private $activity = "activity";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getFacilities()
    {
        return $this->facilities;
    }

    public function getFacility()
    {
        return $this->facility;
    }

    public function getFacilityBuildings()
    {
        return $this->facilityBuildings;
    }

    public function getCheck()
    {
        return $this->check;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBuildings()
    {
        return $this->buildings;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getActivity()
    {
        return $this->activity;
    }

    public function getFacilitiesTableBody()
    {
        return $this->facilitiesTableBody;
    }

    public function getFacilityBuildingsBuildingWrapper()
    {
        return $this->facilityBuildingsBuildingWrapper;
    }

    public function getFacilityBuildingsBuildingTable()
    {
        return $this->facilityBuildingsBuildingTable;
    }

    public function getFacilityBuildingsBuildingContent()
    {
        return $this->facilityBuildingsBuildingContent;
    }

    public function getFacilityBuildingsTable()
    {
        return $this->facilityBuildingsTable;
    }
	public function getFacilityBuildingsWrapper()
    {
        return $this->facilityBuildingsWrapper;
    }


}

?>