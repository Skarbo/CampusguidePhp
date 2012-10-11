<?php

class PageCmsCssResource extends ClassCore
{

    // VARIABLES


    private $headerWrapper = "header_wrapper";
    private $headerTable = "header_table";
    private $headerTableCell = "header_table_cell";
    private $bodyWrapper = "page_body_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getHeaderWrapper()
    {
        return $this->headerWrapper;
    }

    public function getHeaderTable()
    {
        return $this->headerTable;
    }

    public function getHeaderTableCell()
    {
        return $this->headerTableCell;
    }

    public function getBodyWrapper()
    {
        return $this->bodyWrapper;
    }

}

?>