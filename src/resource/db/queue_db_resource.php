<?php

class QueueDbResource
{

    // VARIABLES


    private $table = "queue";

    private $fieldId = "queue_id";
    private $fieldType = "queue_type";
    private $fieldPriority = "queue_priority";
    private $fieldArguments = "queue_arguments";
    private $fieldBuildingId = "building_id";
    private $fieldOccurence = "queue_occurence";
    private $fieldError = "queue_error";
    private $fieldUpdated = "queue_updated";
    private $fieldRegistered = "queue_registered";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getTable()
    {
        return Core::constant( "DB_PREFIX" ) . $this->table;
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function getFieldBuildingId()
    {
        return $this->fieldBuildingId;
    }

    public function getFieldOccurence()
    {
        return $this->fieldOccurence;
    }

    public function getFieldRegistered()
    {
        return $this->fieldRegistered;
    }

    // /FUNCTIONS


    public function getFieldArguments()
    {
        return $this->fieldArguments;
    }

    public function getFieldPriority()
    {
        return $this->fieldPriority;
    }

    public function getFieldError()
    {
        return $this->fieldError;
    }

    public function getFieldUpdated()
    {
        return $this->fieldUpdated;
    }

}

?>