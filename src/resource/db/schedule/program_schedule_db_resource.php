<?php

class ProgramScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_program";
    private $tableEntry = "schedule_entry_program";

    private $fieldId = "program_id";
    private $fieldWebsiteId = "website_id";
    private $fieldCode = "program_code";
    private $fieldName = "program_name";
    private $fieldNameShort = "program_name_short";
    private $fieldUpdated = "program_updated";
    private $fieldRegistered = "program_registered";

    private $fieldEntryEntryId = "entry_id";
    private $fieldEntryProgramId = "program_id";
    private $fieldEntryUpdated = "entry_program_updated";

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


    public function getTableEntry()
    {
        return $this->tableEntry;
    }

    public function getFieldEntryEntryId()
    {
        return $this->fieldEntryEntryId;
    }

    public function getFieldEntryProgramId()
    {
        return $this->fieldEntryProgramId;
    }

    public function getFieldEntryUpdated()
    {
        return $this->fieldEntryUpdated;
    }

}

?>