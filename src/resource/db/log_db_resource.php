<?php

class LogDbResource
{

    // VARIABLES


    private $table = "log";

    private $fieldId = "log_id";
    private $fieldType = "log_type";
    private $fieldText = "log_text";
    private $fieldWebsiteId = "website_id";
    private $fieldScheduleType = "schedule_type";
    private $fieldUpdated = "log_updated";
    private $fieldRegistered = "log_registered";

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

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldText()
    {
        return $this->fieldText;
    }

    public function getFieldWebsiteId()
    {
        return $this->fieldWebsiteId;
    }

    public function getFieldScheduleType()
    {
        return $this->fieldScheduleType;
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