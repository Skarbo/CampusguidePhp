<?php

abstract class TypeScheduleModel extends AbstractWebsiteScheduleModel
{

    // VARIABLES


    const TYPE_ROOM = "room", TYPE_FACULTY = "faculty", TYPE_GROUP = "group", TYPE_PROGRAM = "program";

    private $code;
    private $name;
    private $nameShort;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getNameShort()
    {
        return $this->nameShort;
    }

    public function setNameShort( $nameShort )
    {
        $this->nameShort = $nameShort;
    }

    /**
     * @param TypeScheduleModel $type
     * @return boolean True if equal
     */
    public function isEqual( TypeScheduleModel $type )
    {
        $codeEqual = $this->getCode() == $type->getCode() || !$this->getCode() || !$type->getCode();
        $nameEqual = $this->getName() == $type->getName() || !$this->getName() || !$type->getName();
        $nameShortEqual = $this->getNameShort() == $type->getNameShort() || !$this->getNameShort() || !$type->getNameShort();
        return $codeEqual && $nameEqual && $nameShortEqual;
    }

    /**
     * @return TypeScheduleModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // /FUNCTIONS


}

?>