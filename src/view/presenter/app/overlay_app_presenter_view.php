<?php

class OverlayAppPresenterView extends AbstractPresenterView
{

    // VARIABLES


    private $title;
    private $body;
    private $id;
    private $fitParent;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setTitle( $title )
    {
        $this->title = $title;
    }

    public function setBody( $body )
    {
        $this->body = $body;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }


    public function getFitParent()
    {
        return $this->fitParent;
    }

    public function setFitParent( $fitParent )
    {
        $this->fitParent = $fitParent;
    }

    // ... /GETTERS/SETTERS


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create overlay wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->getHide(), Resource::css()->app()->getOverlayWrapper() )->id( $this->getId() );

        if ( $this->getFitParent() )
        {
            $wrapper->attr("data-fitparent", $this->getFitParent());
        }

        // Create overlay
        $overlay = Xhtml::div()->class_( Resource::css()->app()->getOverlay() );

        // Add title to overlay
        $overlay->addContent(
                Xhtml::h( 1, $this->getTitle() )->class_( Resource::css()->app()->getOverlayTitle() ) );

        // Add body to overlay
        $overlay->addContent(
                Xhtml::div( $this->getBody() )->class_( Resource::css()->app()->getOverlayBody() ) );

        // Add overlay to wrapper
        $wrapper->addContent( Xhtml::div( $overlay ) );

        // Add overlay dialog wrapper to root
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS



}

?>