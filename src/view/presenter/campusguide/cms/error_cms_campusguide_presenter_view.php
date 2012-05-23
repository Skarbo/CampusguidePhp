<?php

class ErrorCmsCampusguidePresenterView extends PresenterView
{

    // VARIABLES


    /**
     * @var AbstractException
     */
    private $error;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return AbstractException
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param AbstractException $error
     */
    public function setError( AbstractException $error )
    {
        $this->error = $error;
    }

    // ... /GETTERS/SETTERS


    /**
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create header
        $header = Xhtml::h( 1, $this->getError()->getMessage() );

        // Create body
        $backLink = Xhtml::a( "going back" )->href( "javascript:history.back(1)" );
        $body = Xhtml::div( sprintf( "Try %s", $backLink ) );

        // Add error to root
        $root->addContent(
                Xhtml::div( $header )->addContent( $body )->class_( Resource::css()->campusguide()->cms()->getError(),
                        get_class( $this->getError() ) ) );

    }

    // /FUNCTIONS


}

?>