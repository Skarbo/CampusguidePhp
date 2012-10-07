<?php

class OverlayCmsPresenterView extends AbstractPresenterView
{

    // VARIABLES


    private $title;
    private $body;
    private $id;

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

    // ... /GETTERS/SETTERS


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create overlay wrapper
        $overlayWrapper = Xhtml::div()->class_( Resource::css()->cms()->getOverlayWrapper(),
                Resource::css()->cms()->getHide() )->id( $this->getId() );

        // Create overlay
        $overlay = Xhtml::div()->class_( Resource::css()->cms()->getOverlay() );

        // Add title to overlay
        $overlay->addContent(
                Xhtml::h( 1, $this->getTitle() )->class_( Resource::css()->cms()->getOverlayTitle() ) );

        // Add body to overlay
        $overlay->addContent(
                Xhtml::div( $this->getBody() )->class_( Resource::css()->cms()->getOverlayBody() ) );

        // Add buttons to overlay
        $buttons = Xhtml::div()->class_( Resource::css()->gui()->getGui(), "theme2" );
        $buttons->addContent(
                Xhtml::div( "Cancel" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->cms()->getOverlayButtonsCancel() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "cross" ) );
        $buttons->addContent(
                Xhtml::div( "OK" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->cms()->getOverlayButtonsOk() )->attr( "data-type",
                        "button_icon" )->attr( "data-icon", "check" ) );

        $overlay->addContent( Xhtml::div( $buttons )->class_( Resource::css()->getRight(), Resource::css()->cms()->getOverlayButtons() ) );

        // Add overlay to wrapper
        $overlayWrapper->addContent( Xhtml::div( $overlay ) );

        // Add overlay dialog wrapper to root
        $root->addContent( $overlayWrapper );

    }

    // /FUNCTIONS


}

?>