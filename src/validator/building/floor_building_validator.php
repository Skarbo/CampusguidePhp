<?php

class FloorBuildingValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @return FloorBuildingModel
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
        $this->validateCharacters( "Floor name", $this->getModel()->getName() );
    }

    /**
     * @throws Exception
     */
    protected function doOrder()
    {
        if ( !is_numeric( $this->getModel()->getOrder() ) || $this->getModel()->getOrder() < 0 )
        {
            throw new Exception( sprintf( "Floor order (#%d) is not correct", $this->getModel()->getOrder() ) );
        }
    }

    // /FUNCTIONS


}

?>