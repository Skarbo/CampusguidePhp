<?php

abstract class PageCmsCampusguidePageMainView extends PageMainView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see PageMainView::getView()
     * @return CmsCampusguideMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @return string Wrapper id
     */
    protected abstract function getWrapperId();

    /**
     * @see PageMainView::getLocale()
     * @return DefaultLocale
     */
    public function getLocale()
    {
        return parent::getLocale();
    }

    // ... /GET


    // ... DRAW


    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawHeader( AbstractXhtml $root );

    /**
     * @param AbstractXhtml $root
     */
    protected abstract function drawBody( AbstractXhtml $root );

    /**
     * @see PageMainView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->id( $this->getWrapperId() );

        // Create header
        $headerWrapper = Xhtml::div()->class_(
                Resource::css()->campusguide()->cms()->page()->getHeaderWrapper() );
        $this->drawHeader( $headerWrapper );

        // Add header to wrapper
        $wrapper->addContent( $headerWrapper );

        // Create error
        $errorWrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->getError() );
        $this->drawErrors( $errorWrapper );

        // Add error to wrapper
        $wrapper->addContent( $errorWrapper );

        // Create body
        $bodyWrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->page()->getTableWrapper() );
        $this->drawBody( $bodyWrapper );

        // Add body to wrapper
        $wrapper->addContent( $bodyWrapper );

        // Add page wrapper to root
        $root->addContent( $wrapper );

    }

    /**
     * @param AbstractXhtml $root
     */
    protected function drawErrors( AbstractXhtml $root )
    {

    }

    // ... /DRAW


    // /FUNCTIONS


}

?>