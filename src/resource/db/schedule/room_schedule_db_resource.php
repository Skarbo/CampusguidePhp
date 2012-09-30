<?php

class RoomScheduleDbResource
{

    // VARIABLES


    private $table = "schedule_room";
    private $tableEntry = "schedule_entry_room";

    private $fieldId = "room_id";
    private $fieldWebsiteId = "website_id";
    private $fieldElementId = "element_id";
    private $fieldCode = "room_code";
    private $fieldName = "room_name";
    private $fieldNameShort = "room_name_short";
    private $fieldUpdated = "room_updated";
    private $fieldRegistered = "room_registered";

    private $fieldEntryEntryId = "entry_id";
    private $fieldEntryRoomId = "room_id";
    private $fieldEntryUpdated = "entry_room_updated";

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

    public function getFieldElementId()
    {
        return $this->fieldElementId;
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

    public function getFieldEntryRoomId()
    {
        return $this->fieldEntryRoomId;
    }

    public function getFieldEntryUpdated()
    {
        return $this->fieldEntryUpdated;
    }

}

?>