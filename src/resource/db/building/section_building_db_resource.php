<?php

class SectionBuildingDbResource
{

    // VARIABLES


    private $table = "building_section";

    private $fieldId = "section_id";
    private $fieldBuildingId = "building_id";
    private $fieldName = "section_name";
    private $fieldCoordinates = "section_coordinates";
    private $fieldUpdated = "section_updated";
    private $fieldRegistered = "section_registered";

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

    public function getFieldBuildingId()
    {
        return $this->fieldBuildingId;
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


}

?>