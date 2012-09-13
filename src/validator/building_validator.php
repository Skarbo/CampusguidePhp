<?php

class BuildingValidator extends Validator
{

    // VARIABLES


    private static $REGEX_GPS = '/[0-9]{1,2}\.[0-9]{1,9}/i';

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
            foreach ( $addressFiltered as $addressField )
            {
                $this->validateCharacters( "Address", $addressField );
            }
            if ( count( $addressFiltered ) != 0 && count( $addressFiltered ) != count( $this->getModel()->getAddress() ) )
            {
                throw new Exception( "Either a full address must be given or none at all" );
            }
        }
        if ( $this->getModel()->getLocation() && !$this->getModel()->getAddress() )
        {
            throw new Exception( "Address must be given if location is given" );
        }
    }

    /**
     * @throws Exception
     */
    protected function doLocation()
    {
        if ( $this->getModel()->getLocation() )
        {
            foreach ( $this->getModel()->getLocation() as $location )
            {
                if ( !preg_match( self::$REGEX_GPS, $location ) )
                {
                    throw new Exception( "Location is not legally formatted" );
                }
            }
        }
        if ( $this->getModel()->getAddress() && !$this->getModel()->getLocation() )
        {
            throw new Exception( "Location must be given if address is given" );
        }
    }

    /**
     * @throws Exception
     */
    protected function doPosition()
    {
        if ( $this->getModel()->getPosition() )
        {
            $positionFiltered = array_filter( $this->getModel()->getPosition(), function( $var ) {
                return is_array( $var ) ? array_sum( $var ) : $var;
            } );
            foreach ( $positionFiltered as $positionField )
            {
                foreach ( $positionField as $position )
                {
                        if ( !preg_match( self::$REGEX_GPS, "" . $position ) )
                    {
                        throw new Exception( "Position is not legally formatted" );
                    }
                }
            }
            if ( count( $positionFiltered ) != 0 && count( $positionFiltered ) != count(
                    $this->getModel()->getPosition() ) )
            {
                throw new Exception( "Either all positions must be given or none at all" );
            }
        }
    }

    // /FUNCTIONS


}

?>