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

    // /FUNCTIONS


}

?>