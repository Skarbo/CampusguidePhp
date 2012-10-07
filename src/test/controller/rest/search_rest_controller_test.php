<?php

class SearchRestControllerTest extends ControllerTest
{

    // VARIABLES


    protected static $QUERY_GET_SEARCH = "%s/%s";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "SearchRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    // ... ... QUERY


    protected function getQueryGetSearch( $search )
    {
        return sprintf( self::$QUERY_GET_SEARCH, SearchRestController::$CONTROLLER_NAME,
                urlencode( $search ) );
    }

    // ... ... /QUERY


    // ... /GET


    public function testShouldSearch()
    {

        // Add Facility
        $facility = $this->getDaoContainerTest()->addFacility();

        // Add Buildings
        $buildings = new BuildingListModel();
        $buildings->add($this->getDaoContainerTest()->addBuilding($facility->getId()));
        $buildings->add($this->getDaoContainerTest()->addBuilding($facility->getId()));
        $buildings->add($this->getDaoContainerTest()->addBuilding($facility->getId()));

        // Get Website
        $searchString = "Test";
        $url = self::getRestWebsite( $this->getQueryGetSearch( $searchString ) );

        // Do GET
        $data = $this->get( $url );
        $dataArray = json_decode( $data, true );

        $this->showHeaders();
        $this->showRequest();
        $this->showSource();

        // Assert response
        if ( $this->assertResponse( AbstractController::STATUS_OK, "Should be correct response" ) )
        {

        }

    }

    // /FUNCTIONS


}

?>