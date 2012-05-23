<?php

interface CampusguideInterfaceController
{

    /**
     * @return FacilityDao
     */
    public function getFacilityDao();

    /**
     * @param FacilityDao $facilityDao
     */
    public function setFacilityDao( FacilityDao $facilityDao );

    /**
     * @return BuildingDao
     */
    public function getBuildingDao();

    /**
     * @param BuildingDao $buildingDao
     */
    public function setBuildingDao( BuildingDao $buildingDao );

    /**
     * @return SectionBuildingDao
     */
    public function getSectionBuildingDao();

    /**
     * @param SectionBuildingDao $sectionBuildingDao
     */
    public function setSectionBuildingDao( SectionBuildingDao $sectionBuildingDao );

    /**
     * @return ElementBuildingDao
     */
    public function getElementBuildingDao();

    /**
     * @param ElementBuildingDao $roomBuildingDao
     */
    public function setElementBuildingDao( ElementBuildingDao $roomBuildingDao );

    /**
     * @return TypeElementBuildingDao
     */
    public function getTypeElementBuildingDao();

    /**
     * @param TypeElementBuildingDao $elementBuildingDao
     */
    public function setTypeElementBuildingDao( TypeElementBuildingDao $elementBuildingDao );

    /**
     * @return GroupTypeElementBuildingDao
     */
    public function getGroupTypeElementBuildingDao();

    /**
     * @param GroupTypeElementBuildingDao $groupTypeElementBuildingDao
     */
    public function setGroupTypeElementBuildingDao( GroupTypeElementBuildingDao $groupTypeElementBuildingDao );

    /**
     * @return FloorBuildingDao
     */
    public function getFloorBuildingDao();

    /**
     * @param FloorBuildingDao $floorBuildingDao
     */
    public function setFloorBuildingDao( FloorBuildingDao $floorBuildingDao );

}

?>