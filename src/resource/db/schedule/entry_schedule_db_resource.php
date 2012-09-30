<?php

class EntryScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_entry";
    private $tableOccurence = "schedule_entry_occurence";

    private $fieldId = "entry_id";
    private $fieldWebsiteId = "website_id";
    private $fieldType = "entry_type";
    private $fieldTimeStart = "entry_time_start";
    private $fieldTimeEnd = "entry_time_end";
    private $fieldUpdated = "entry_updated";
    private $fieldRegistered = "entry_registered";

    private $fieldAliasOccurence = "entry_occurence";

    private $fieldOccurenceEntryId = "entry_id";
    private $fieldOccurenceDate = "entry_occurence_date";
    private $fieldOccurenceUpdated = "entry_occurence_updated";

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

    public function getFieldWebsiteId()
    {
        return $this->fieldWebsiteId;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldTimeStart()
    {
        return $this->fieldTimeStart;
    }

    public function getFieldTimeEnd()
    {
        return $this->fieldTimeEnd;
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


    public function getTableOccurence()
    {
        return $this->tableOccurence;
    }

    public function getFieldOccurenceEntryId()
    {
        return $this->fieldOccurenceEntryId;
    }

    public function getFieldOccurenceDate()
    {
        return $this->fieldOccurenceDate;
    }

    public function getFieldOccurenceUpdated()
    {
        return $this->fieldOccurenceUpdated;
    }

    public function getFieldAliasOccurence()
    {
        return $this->fieldAliasOccurence;
    }

}

?>