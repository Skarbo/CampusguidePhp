<?php

class ElementBuildingDbResource
{

    // VARIABLES


    private $table = "building_element";

    private $fieldId = "element_id";
    private $fieldSectionId = "section_id";
    private $fieldTypeId = "element_type_id";
    private $fieldFloorId = "floor_id";
    private $fieldName = "element_name";
    private $fieldCoordinates = "element_coordinates";
    private $fieldDeleted = "element_deleted";
    private $fieldUpdated = "element_updated";
    private $fieldRegistered = "element_registered";

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

    public function getFieldSectionId()
    {
        return $this->fieldSectionId;
    }

    public function getFieldTypeId()
    {
        return $this->fieldTypeId;
    }

    public function getFieldFloorId()
    {
        return $this->fieldFloorId;
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


    public function getFieldDeleted()
    {
        return $this->fieldDeleted;
    }

}

?>