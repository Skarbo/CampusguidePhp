<?php

class WebsiteScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_website";
    private $tableBuilding = "schedule_website_building";

    private $fieldId = "website_id";
    private $fieldUrl = "website_url";
    private $fieldType = "website_type";
    private $fieldParsed = "website_parsed";
    private $fieldRegistered = "website_registered";

    private $fieldBuildingWebsiteId = "website_id";
    private $fieldBuildingBuildingId = "building_id";

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

    public function getFieldUrl()
    {
        return $this->fieldUrl;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldParsed()
    {
        return $this->fieldParsed;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getTableBuilding()
    {
        return $this->tableBuilding;
    }

    public function getFieldBuildingWebsiteId()
    {
        return $this->fieldBuildingWebsiteId;
    }

    public function getFieldBuildingBuildingId()
    {
        return $this->fieldBuildingBuildingId;
    }

}

?>