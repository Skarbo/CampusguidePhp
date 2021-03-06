<?php

class ElementBuildingDbResource
{

    // VARIABLES


    private $table = "building_element";

    private $fieldId = "element_id";
    private $fieldSectionId = "section_id";
    private $fieldType = "element_type";
    private $fieldTypeGroup = "element_type_group";
    private $fieldFloorId = "floor_id";
    private $fieldName = "element_name";
    private $fieldCoordinates = "element_coordinates";
    private $fieldData = "element_data";
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

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldTypeGroup()
    {
        return $this->fieldTypeGroup;
    }

    /**
     * @return the $fieldData
     */
    public function getFieldData()
    {
        return $this->fieldData;
    }

}

?>