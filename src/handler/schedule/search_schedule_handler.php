<?php

class SearchScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function handle( $search )
    {

        // Search string
        $searchString = $this->getSearchString();

        // SEARCH


        $programs = ProgramScheduleListModel::get_(
                $this->daoContainer->getProgramScheduleDao()->search( $searchString ) );
        $faculties = $this->daoContainer->getFacultyScheduleDao()->search( $searchString );
        $rooms = $this->daoContainer->getRoomScheduleDao()->search( $searchString );

        $search = array ();
        if ( !$programs->isEmpty() )
        {
            $search[ "program" ] = $programs->getIds();
        }
        if ( !$faculties->isEmpty() )
        {
            $search[ "faculty" ] = $faculties->getIds();
        }
        if ( !$rooms->isEmpty() )
        {
            $search[ "room" ] = $rooms->getIds();
        }

        if ( !empty( $search ) )
        {
            $this->entries = $this->daoContainer->getEntryScheduleDao()->search( $search );
        }

        $programIds = $this->entries->getProgramIds();
        $roomIds = $this->entries->getRoomIds();
        $facultyIds = $this->entries->getFacultyIds();

        $programs = $this->daoContainer->getProgramScheduleDao()->getList( $programIds );
        $faculties = $this->daoContainer->getFacultyScheduleDao()->getList( $facultyIds );
        $rooms = $this->daoContainer->getRoomScheduleDao()->getList( $roomIds );

        // /SEARCH


        return array ( "programs" => $programs, "faculties" => $faculties, "rooms" => $rooms );

    }

    private function getSearchString()
    {
        return sprintf( "%%%s%%", preg_replace( "/[^\\w]/", "%", self::getSearchUri() ) );
    }

    // /FUNCTIONS


}

?>