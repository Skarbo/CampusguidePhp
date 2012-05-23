<?php

class GroupTypeElementBuildingValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return GroupTypeElementBuildingModel
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
        $this->validateCharacters( "Group name", $this->getModel()->getName() );
    }

    // /FUNCTIONS


}

?>