<?php

abstract class TypesScheduleAlgorithmResultParser extends AlgorithmResultParser
{

    // VARIABLES


    /**
     * @var TypeScheduleListModel
     */
    private $types;
    private $start = 0;
    private $end = 0;
    private $total = 0;
    protected $prPage = 0;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return TypeScheduleListModel
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param TypeScheduleListModel $types
     */
    public function setTypes( TypeScheduleListModel $types )
    {
        $this->types = $types;
    }

    public function getPages()
    {
        return ceil( $this->total / max( $this->prPage, 1 ) );
    }

    public function getPage()
    {
        return ceil( $this->start / max( $this->prPage, 1 ) );
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setStart( $start )
    {
        $this->start = $start;
    }

    public function setTotal( $total )
    {
        $this->total = $total;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd( $end )
    {
        $this->end = $end;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param TypesScheduleAlgorithmResultParser $get
     * @return TypesScheduleAlgorithmResultParser
     */
    public static function get_( $get )
    {
        return $get;
    }

    // /FUNCTIONS


}

?>