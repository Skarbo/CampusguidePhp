<?php

class NodeNavigationBuildingDbResource
{

    // VARIABLES


    private $table = "building_navigation_node";

    private $fieldId = "node_id";
    private $fieldFloorId = "floor_id";
    private $fieldElementId = "element_id";
    private $fieldCoordinate = "node_coordinate";
    private $fieldUpdated = "node_updated";
    private $fieldRegistered = "node_registered";

    private $fieldAliasEdges = "node_edges";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldFloorId()
    {
        return $this->fieldFloorId;
    }

    public function getFieldElementId()
    {
        return $this->fieldElementId;
    }

    public function getFieldCoordinate()
    {
        return $this->fieldCoordinate;
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


    public function getFieldAliasEdges()
    {
        return $this->fieldAliasEdges;
    }

}

?>