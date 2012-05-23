<?php

class TypeElementBuildingValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return TypeElementBuildingModel
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
        $this->validateCharacters( "Type name", $this->getModel()->getName() );
    }

    // /FUNCTIONS


}

?>