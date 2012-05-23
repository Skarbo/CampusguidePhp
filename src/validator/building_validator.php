<?php

class BuildingValidator extends Validator
{

    // VARIABLES


    private static $REGEX_LOCATION = '/[0-9]{1,2}\.[0-9]{1,9}\,[0-9]{1,2}\.[0-9]{1,9}/i';

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return BuildingModel
     */
    function getModel()
    {
        return parent::getModel();
    }

    // ... /GET


    /**
     * @throws Exception
     */
    protected function doName()
    {
        $this->validateCharacters( "Name", $this->getModel()->getName() );
        $this->validateLength( "Name", $this->getModel()->getName(), 3 );
    }

    /**
     * @throws Exception
     */
    protected function doCoordinates()
    {
        if ( !Core::isDoubleArray( $this->getModel()->getCoordinates() ) )
        {
            throw new Exception( "Coordinates must be double array" );
        }
    }

    /**
     * @throws Exception
     */
    protected function doFacility()
    {
        if ( !$this->getModel()->getFacilityId() )
        {
            throw new Exception( "Facility must be given" );
        }
    }

    /**
     * @throws Exception
     */
    protected function doAddress()
    {
        if ( $this->getModel()->getAddress() )
        {
            $addressFiltered = array_filter( $this->getModel()->getAddress() );
            foreach ( $this->getModel()->getAddress() as $addressField )
            {
                $this->validateCharacters( "Address", $addressField );
            }
            if ( count( $addressFiltered ) != 0 && count( $addressFiltered ) != count( $this->getModel()->getAddress() ) )
            {
                throw new Exception( "Either a full address must be given or none at all" );
            }
        }
    }

    /**
     * @throws Exception
     */
    protected function doLocation()
    {
        if ( $this->getModel()->getLocation() && !preg_match( self::$REGEX_LOCATION, $this->getModel()->getLocation() ) )
        {
            throw new Exception( "Location is not legally formatted" );
        }
    }

    // /FUNCTIONS


}

?>