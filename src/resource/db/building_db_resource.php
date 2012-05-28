<?php

class BuildingDbResource
{

    // VARIABLES


    private $table = "building";

    private $fieldId = "building_id";
    private $fieldFacilityId = "facility_id";
    private $fieldName = "building_name";
    private $fieldCoordinates = "building_coordinates";
    private $fieldPosition = "building_position";
    private $fieldAddress = "building_address";
    private $fieldUpdated = "building_updated";
    private $fieldRegistered = "building_registered";

    private $fieldAliasFloors = "building_floors";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldFacilityId()
    {
        return $this->fieldFacilityId;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldCoordinates()
    {
        return $this->fieldCoordinates;
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


    public function getFieldPosition()
    {
        return $this->fieldPosition;
    }

    public function getFieldAddress()
    {
        return $this->fieldAddress;
    }

    public function getFieldAliasFloors()
    {
        return $this->fieldAliasFloors;
    }

}

?>