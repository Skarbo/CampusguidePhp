<?php

class FacilityDbResource
{

    // VARIABLES


    private $table = "facility";

    private $fieldId = "facility_id";
    private $fieldName = "facility_name";
    private $fieldUpdated = "facility_updated";
    private $fieldRegistered = "facility_registered";

    private $fieldAliasBuildings = "facility_buildings";

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

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getFieldAliasBuildings()
    {
        return $this->fieldAliasBuildings;
    }

}

?>