<?php

class SearchCampusguideRestControllerTest extends CampusguideControllerTest
{

    // VARIABLES


    protected static $QUERY_GET_SEARCH = "%s/%s";

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct()
    {
        parent::__construct( "SearchCampusguideRestController Test" );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    // ... ... QUERY


    protected function getQueryGetSearch( $search )
    {
        return sprintf( self::$QUERY_GET_SEARCH, SearchCampusguideRestController::$CONTROLLER_NAME,
                urlencode( $search ) );
    }

    // ... ... /QUERY


    // ... /GET


    public function testShouldSearch()
    {

        // Add Facility
        $facility = $this->getCampusguideHandlerTest()->addFacility();

        // Add Buildings
        $buildings = new BuildingListModel();
        $buildings->add($this->getCampusguideHandlerTest()->addBuilding($facility->getId()));
        $buildings->add($this->getCampusguideHandlerTest()->addBuilding($facility->getId()));
        $buildings->add($this->getCampusguideHandlerTest()->addBuilding($facility->getId()));

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
        if ( $this->assertResponse( Controller::STATUS_OK, "Should be correct response" ) )
        {

        }

    }

    // /FUNCTIONS


}

?>