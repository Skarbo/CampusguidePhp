<?php

class SectionBuildingValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return SectionBuildingModel
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
        $this->validateCharacters( "Section name", $this->getModel()->getName() );
    }

    /**
     * @throws Exception
     */
    protected function doCoordinates()
    {
        if ( !Core::isDoubleArray( $this->getModel()->getCoordinates() ) )
        {
            throw new Exception( "Section coordinates must be double array" );
        }
    }

    // /FUNCTIONS


}

?>