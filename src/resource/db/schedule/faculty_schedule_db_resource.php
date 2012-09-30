<?php

class FacultyScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_faculty";
    private $tableEntry = "schedule_entry_faculty";

    private $fieldId = "faculty_id";
    private $fieldWebsiteId = "website_id";
    private $fieldRoomId = "room_id";
    private $fieldCode = "faculty_code";
    private $fieldType = "faculty_type";
    private $fieldName = "faculty_name";
    private $fieldNameShort = "faculty_name_short";
    private $fieldPhone = "faculty_phone";
    private $fieldEmail = "faculty_email";
    private $fieldUpdated = "faculty_updated";
    private $fieldRegistered = "faculty_registered";

    private $fieldEntryEntryId = "entry_id";
    private $fieldEntryFacultyId = "faculty_id";
    private $fieldEntryUpdated = "entry_faculty_updated";

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

    public function getFieldRoomId()
    {
        return $this->fieldRoomId;
    }

    public function getFieldCode()
    {
        return $this->fieldCode;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function getFieldNameShort()
    {
        return $this->fieldNameShort;
    }

    public function getFieldPhone()
    {
        return $this->fieldPhone;
    }

    public function getFieldEmail()
    {
        return $this->fieldEmail;
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

    public function getFieldEntryFacultyId()
    {
        return $this->fieldEntryFacultyId;
    }

    public function getFieldEntryUpdated()
    {
        return $this->fieldEntryUpdated;
    }

}

?>