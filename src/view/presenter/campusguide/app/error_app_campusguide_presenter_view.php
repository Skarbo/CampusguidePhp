<?php

class ErrorAppCampusguidePresenterView extends PresenterView
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
        $backLink = Xhtml::a( "Go back" )->href( "javascript:history.back(1)" )->class_(Resource::css()->campusguide()->app()->getButton());
        $body = Xhtml::div( $backLink );

        // Add error to root
        $root->addContent(
                Xhtml::div( $header )->addContent( $body )->class_( Resource::css()->campusguide()->app()->getError(),
                        get_class( $this->getError() ) ) );

    }

    // /FUNCTIONS


}

?>