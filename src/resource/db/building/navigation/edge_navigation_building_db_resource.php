<?php

class EdgeNavigationBuildingDbResource
{

    // VARIABLES


    private $table = "building_navigation_edge";

    private $fieldNodeLeft = "node_left";
    private $fieldNodeRight = "node_right";
    private $fieldUpdated = "edge_updated";
    private $fieldRegistered = "edge_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

	public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldNodeLeft()
    {
        return $this->fieldNodeLeft;
    }

    public function getFieldNodeRight()
    {
        return $this->fieldNodeRight;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }


    // /FUNCTIONS


}

?>