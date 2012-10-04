<?php

class EntriesScheduleResultWebsiteHandler extends ClassCore
{

    // VARIABLES


    const CODE_FINISHED = "finished";
    const CODE_EXCEEDING = "exceeding";

    private $code;
    private $count = 0;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $count, $code )
    {
        $this->count = $count;
        $this->code = $code;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount( $count )
    {
        $this->count = $count;
    }

}

?>