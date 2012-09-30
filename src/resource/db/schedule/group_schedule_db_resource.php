<?php

class GroupScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_group";
    private $tableEntry = "schedule_entry_group";

    private $fieldId = "group_id";
    private $fieldWebsiteId = "website_id";
    private $fieldCode = "group_code";
    private $fieldName = "group_name";
    private $fieldNameShort = "group_name_short";
    private $fieldUpdated = "group_updated";
    private $fieldRegistered = "group_registered";

    private $fieldEntryEntryId = "entry_id";
    private $fieldEntryGroupId = "group_id";
    private $fieldEntryUpdated = "entry_group_updated";

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

    public function getFieldCode()
    {
        return $this->fieldCode;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldNameShort()
    {
        return $this->fieldNameShort;
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


    public function getFieldEntryEntryId()
    {
        return $this->fieldEntryEntryId;
    }

    public function getFieldEntryGroupId()
    {
        return $this->fieldEntryGroupId;
    }

    public function getTableEntry()
    {
        return $this->tableEntry;
    }

    public function getFieldEntryUpdated()
    {
        return $this->fieldEntryUpdated;
    }

}

?>