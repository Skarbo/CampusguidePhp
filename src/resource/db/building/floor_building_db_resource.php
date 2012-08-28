<?php

class FloorBuildingDbResource
{

    // VARIABLES


    private $table = "building_floor";

    private $fieldId = "floor_id";
    private $fieldBuildingId = "building_id";
    private $fieldName = "floor_name";
    private $fieldCoordinates = "floor_coordinates";
    private $fieldMain = "floor_main";
    private $fieldOrder = "floor_order";
    private $fieldUpdated = "floor_updated";
    private $fieldRegistered = "floor_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return DB_PREFIX . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldBuildingId()
    {
        return $this->fieldBuildingId;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldOrder()
    {
        return $this->fieldOrder;
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


    public function getFieldCoordinates()
    {
        return $this->fieldCoordinates;
    }

    public function getFieldMain()
    {
        return $this->fieldMain;
    }

}

?>