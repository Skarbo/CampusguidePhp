<?php

class WebsiteScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_website";

    private $fieldId = "website_id";
    private $fieldUrl = "website_url";
    private $fieldType = "website_type";
    private $fieldParsed = "website_parsed";
    private $fieldRegistered = "website_registered";

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


}

?>