<?php

class QueueValidator extends Validator
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see Validator::getModel()
     * @return QueueModel
     */
    protected function getModel()
    {
        return parent::getModel();
    }

    // ... /GET


    protected function doType()
    {
        $this->validateValueEquals( "Type", QueueModel::$TYPES, $this->getModel()->getType() );
    }

    protected function doArguments()
    {
        if ( $this->getModel()->getArguments() && !is_array( $this->getModel()->getArguments() ) )
        {
            throw new Exception( "Arguments must be an array" );
        }
    }

    // /FUNCTIONS


}

?>