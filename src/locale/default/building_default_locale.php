<?php

class BuildingDefaultLocale extends Locale
{

    // VARIABLES


    protected $building = "Building";
    protected $buildings = "Buildings";
    protected $floor = "Floor";
    protected $floors = "Floors";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getBuilding()
    {
        return $this->building;
    }

    public function getBuildings()
    {
        return $this->buildings;
    }

    public function getFloor()
    {
        return $this->floor;
    }

    public function getFloors()
    {
        return $this->floors;
    }

}

?>