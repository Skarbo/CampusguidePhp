<?php

class ElementBuildingValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return ElementBuildingModel
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
        $this->validateCharacters( "Element name", $this->getModel()->getName() );
    }

    /**
     * @throws Exception
     */
    protected function doCoordinates()
    {
        if ( !Core::isDoubleArray( $this->getModel()->getCoordinates() ) )
        {
            throw new Exception( "Element coordinates must be double array" );
        }
    }

    // /FUNCTIONS


}

?>