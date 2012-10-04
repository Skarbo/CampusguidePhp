<?php

class TypesScheduleResultWebsiteHandler extends ClassCore
{

    // VARIABLES


    const CODE_FINISHED = "finished";
    const CODE_EXCEEDPAGES = "exceedpages";
    const CODE_EMPTYTYPES = "emptytypes";

    private $page = 0;
    private $pages = 0;
    private $finished = false;
    private $code;
    private $count = 0;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $page, $pages, $finished, $code = self::CODE_FINISHED, $count = 0 )
    {
        $this->page = $page;
        $this->pages = $pages;
        $this->finished = $finished;
        $this->code = $code;
        $this->count = $count;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function getPage()
    {
        return $this->page;
    }

    public function setPage( $page )
    {
        $this->page = $page;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setPages( $pages )
    {
        $this->pages = $pages;
    }

    public function isFinished()
    {
        return $this->finished;
    }

    public function setFinished( $finished )
    {
        $this->finished = $finished;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }

    // /FUNCTIONS


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