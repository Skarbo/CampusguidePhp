<?php

class BuildingCmsCssResource extends ClassCore
{

    // VARIABLES


    private $buildings = "buildings";
    private $buildingsTableBody = "buildings_table_body";
    private $building = "building";

    private $buildingBuildings = "building_buildings";
    private $buildingBuildingsWrapper = "building_buildings_wrapper";
    private $buildingBuildingsTable = "building_buildings_table";
    private $buildingBuildingsBuildingWrapper = "building_buildings_building_wrapper";
    private $buildingBuildingsBuildingTable = "building_buildings_building_table";
    private $buildingBuildingsBuildingContent = "building_buildings_building_content";

    private $buildingCheck = "check";
    private $buildingFacility = "facility";
    private $buildingOverview = "overview";
    private $buildingBuilding = "building_building";
    private $buildingBuildingName = "name";
    private $buildingBuildingAddress = "address";
    private $buildingFloors = "floors";
    private $buildingActivity = "activity";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getBuilding()
    {
        return $this->building;
    }

    public function getBuildingCheck()
    {
        return $this->buildingCheck;
    }

    public function getBuildingFacility()
    {
        return $this->buildingFacility;
    }

    public function getBuildingOverview()
    {
        return $this->buildingOverview;
    }

    public function getBuildingBuilding()
    {
        return $this->buildingBuilding;
    }

    public function getBuildingFloors()
    {
        return $this->buildingFloors;
    }

    public function getBuildingActivity()
    {
        return $this->buildingActivity;
    }

    public function getBuildingBuildingName()
    {
        return $this->buildingBuildingName;
    }

    public function getBuildingBuildingAddress()
    {
        return $this->buildingBuildingAddress;
    }

}

?>