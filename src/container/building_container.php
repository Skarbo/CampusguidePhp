<?php

class BuildingContainer extends ClassCore
{

    // VARIABLES


    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var ElementBuildingListModel
     */
    private $elements;
    /**
     * @var FloorBuildingListModel
     */
    private $floors;
    /**
     * @var NodeNavigationBuildingListModel
     */
    private $navigations;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        $this->elements = new ElementBuildingListModel();
        $this->floors = new FloorBuildingListModel();
        $this->navigations = new NodeNavigationBuildingListModel();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return BuildingModel
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param BuildingModel $building
     */
    public function setBuilding( BuildingModel $building )
    {
        $this->building = $building;
    }

    /**
     * @return ElementBuildingListModel
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param ElementBuildingListModel $elements
     */
    public function setElements( ElementBuildingListModel $elements )
    {
        $this->elements = $elements;
    }

    /**
     * @return FloorBuildingListModel
     */
    public function getFloors()
    {
        return $this->floors;
    }

    /**
     * @param FloorBuildingListModel $floors
     */
    public function setFloors( FloorBuildingListModel $floors )
    {
        $this->floors = $floors;
    }

    /**
     * @return NodeNavigationBuildingListModel
     */
    public function getNavigations()
    {
        return $this->navigations;
    }

    /**
     * @param NodeNavigationBuildingListModel $navigations
     */
    public function setNavigations( NodeNavigationBuildingListModel $navigations )
    {
        $this->navigations = $navigations;
    }

    // ... /GETTERS/SETTERS


    /**
     * @return Integer Last modified
     */
    public function getLastModified()
    {
        return max( $this->getBuilding() ? $this->getBuilding()->getLastModified() : 0,
                $this->getElements()->getLastModified(), $this->getNavigations()->getLastModified() );
    }

    // /FUNCTIONS


}

?>