<?php

class FacilityValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return FacilityModel
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

    // /FUNCTIONS


}

?>