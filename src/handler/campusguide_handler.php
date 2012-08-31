<?php

class CampusguideHandler extends Handler
{

    // VARIABLES


    /**
     * @var BuildingDao
     */
    private $buildingDao;
    /**
     * @var FloorBuildingDao
     */
    private $floorBuildingDao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DbApi $dbApi )
    {
        $this->setBuildingDao( new BuildingDbDao( $dbApi ) );
        $this->setFloorBuildingDao( new FloorBuildingDbDao( $dbApi ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
    * @return BuildingDao
    */
    public function getBuildingDao()
    {
        return $this->buildingDao;
    }

    /**
    * @param BuildingDao $buildingDao
    */
    private function setBuildingDao( BuildingDao $buildingDao )
    {
        $this->buildingDao = $buildingDao;
    }

    /**
     * @return FloorBuildingDao
     */
    public function getFloorBuildingDao()
    {
        return $this->floorBuildingDao;
    }

    /**
     * @param FloorBuildingDao $floorBuildingDao
     */
    private function setFloorBuildingDao( FloorBuildingDao $floorBuildingDao )
    {
        $this->floorBuildingDao = $floorBuildingDao;
    }

    // /FUNCTIONS


}

?>