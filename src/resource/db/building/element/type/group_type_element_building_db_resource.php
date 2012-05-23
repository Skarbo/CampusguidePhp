<?php

class GroupTypeElementBuildingDbResource
{

    // VARIABLES


    private $table = "building_element_type_group";

    private $fieldId = "group_id";
    private $fieldName = "group_name";
    private $fieldUpdated = "group_updated";
    private $fieldRegistered = "group_registered";

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

    public function getFieldName()
    {
        return $this->fieldName;
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