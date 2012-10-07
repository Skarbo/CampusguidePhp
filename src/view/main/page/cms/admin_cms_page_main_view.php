<?php

abstract class AdminCmsPageMainView extends PageCmsPageMainView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... IS


    /**
     * @return boolean True if action is edit
     */
    protected function isActionEdit()
    {
        return $this->getView()->getController()->isActionEdit();
    }

    // ... /IS


    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected function drawErrors( AbstractXhtml $root )
    {
        parent::drawErrors( $root );

        // Only show validation errors
        $errors = array_filter( $this->getView()->getController()->getErrors(),
                function ( $var )
                {
                    return get_class( $var ) == ValidatorException::class_();
                } );

        // Don't draw if no errors
        if ( !$errors )
        {
            return;
        }

        // Create error wrapper
        $errorWrapper = Xhtml::div()->class_( ValidatorException::class_() );

        // Foreach errors
        foreach ( $errors as $error )
        {
            $error = ValidatorException::get_( $error );

            // Add header to error
            $errorWrapper->addContent( Xhtml::h( 1, $error->getMessage() ) );

            // Foreach validations
            foreach ( $error->getValidations() as $validation )
            {
                // Add validation to error
                $errorWrapper->addContent( Xhtml::div( $validation ) );
            }

        }

        // Add error wrapper to root
        $root->addContent( $errorWrapper );
    }

    // ... /DRAW


    // /FUNCTIONS


}

?>