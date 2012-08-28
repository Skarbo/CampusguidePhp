<?php

class TypeElementBuildingDbResource
{

    // VARIABLES


    private $table = "building_element_type";

    private $fieldId = "type_id";
    private $fieldName = "type_name";
    private $fieldGroupId = "type_group_id";
    private $fieldIcon = "type_icon";
    private $fieldUpdated = "type_updated";
    private $fieldRegistered = "type_registered";

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

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldGroupId()
    {
        return $this->fieldGroupId;
    }

    public function getFieldIcon()
    {
        return $this->fieldIcon;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

}

?>