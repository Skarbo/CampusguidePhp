<?php

class ErrorsAdminCmsPageMainView extends PageCmsPageMainView implements ErrorsAdminCmsInterfaceView
{

    // VARIABLES


    private static $MESSAGE_LENGTH = 75;

    private static $ID_ERRORS_WRAPPER = "errors_page_wrapper";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPageMainView::getView()
     * @return AdminCmsMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see PageCmsPageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_ERRORS_WRAPPER;
    }

    /**
     * @see ErrorsAdminCmsInterfaceView::getErrors()
     */
    public function getErrors()
    {
        return $this->getView()->getErrors();
    }

    // ... /GET


    // ... CREATE


    /**
     * @return AbstractXhtml
     */
    private static function createMessage( $message )
    {
        return Xhtml::span(
                htmlspecialchars(
                        strlen( $message ) > self::$MESSAGE_LENGTH ? sprintf( "%s...",
                                substr( $message, 0, self::$MESSAGE_LENGTH ) ) : $message ) );
    }

    /**
     * @return AbstractXhtml
     */
    private function createActivity( $updated, $registered )
    {
        $activity = max( $updated, $registered );
        return Xhtml::span(
                sprintf( "%s\n%s",
                        Core::ucfirst(
                                $updated > $registered ? $this->getLocale()->getUpdated() : $this->getLocale()->getRegistered() ),
                        $this->getLocale()->timeSince( $activity ) ) )->title( date( "H:i:s D d. M y", $activity ) );
    }

    // ... /CREATE


    /**
     * @see PageCmsPageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->cms()->page()->getHeaderWrapper() );

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // Add header to table
        $table->addContent( Xhtml::div( Xhtml::h( 2, sprintf( "Errors (%d)", $this->getErrors()->size() ) ) ) );

        // Draw sub menu on root
        $cell = Xhtml::div()->class_( Resource::css()->getRight() );
        $this->drawHeaderMenuSub( $cell );
        $table->addContent( $cell );

        // Add table to wrapper
        $wrapper->addContent( $table );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    private function drawHeaderMenuSub( AbstractXhtml $root )
    {
        $search_gui = Xhtml::div()->id( "sub_menu_gui" )->addClass( Resource::css()->gui()->getGui(), "theme2" );

        // Search input
        $search_input = Xhtml::input()->type( InputXhtml::$TYPE_TEXT )->autocomplete( false )->title( "Search" )->id(
                "errors_search" )->addClass( Resource::css()->gui()->getComponent() )->attr( "data-type", "input" )->attr(
                "placeholder", "Search" );

        // Reset button
        $reset_button = Xhtml::a()->id( "errors_search_reset" )->title( "Reset" )->attr( "data-type", "reset" )->attr(
                "data-icon", "cross" )->attr( "data-reset-id", "errors_search" )->addClass(
                Resource::css()->gui()->getComponent() );

        $search_gui->addContent( $search_input );
        $search_gui->addContent( $reset_button );

        $root->addContent( $search_gui );
    }

    /**
     * @see PageCmsPageMainView::drawBody()
     */
    protected function drawBody( AbstractXhtml $root )
    {

        $table = Xhtml::table()->class_( "errors", "cms_table" );

        $thead = Xhtml::thead();
        $tr = Xhtml::tr();
        $tr->addContent( Xhtml::td( "#" )->class_( "id" ) );
        $tr->addContent( Xhtml::td( "Message" )->class_( "message" ) );
        $tr->addContent( Xhtml::td( "Occured" )->class_( "occured" ) );
        $tr->addContent( Xhtml::td( "Activity" )->class_( "activity" ) );
        $thead->addContent( $tr );
        $table->addContent( $thead );

        for ( $this->getErrors()->rewind(); $this->getErrors()->valid(); $this->getErrors()->next() )
        {
            $error = $this->getErrors()->current();

            $tbody = Xhtml::tbody()->class_( "error" );

            $tr = Xhtml::tr();
            $tr->addContent( Xhtml::td( $error->getId() )->rowspan( 3 )->class_( "id" ) );
            $tr->addContent(
                    Xhtml::td( $error->getMessage() )->title( htmlspecialchars( $error->getMessage() ) )->class_(
                            "message" ) );
            $tr->addContent( Xhtml::td( $error->getOccured() )->class_( "occured" ) );
            $tr->addContent(
                    Xhtml::td( $this->createActivity( $error->getUpdated(), $error->getRegistered() ) )->rowspan( 2 )->class_(
                            "activity" ) );
            $tbody->addContent( $tr );

            $tr = Xhtml::tr();
            $tr->addContent(
                    Xhtml::td( sprintf( "%s:%s", $error->getFile(), $error->getLine() ) )->colspan( 2 )->class_(
                            "file" ) );
            $tbody->addContent( $tr );

            $tr = Xhtml::tr();
            $tr->addContent(
                    Xhtml::td( Xhtml::a( urldecode( $error->getUrl() ) )->href( $error->getUrl() ) )->colspan( 2 )->class_(
                            "url" ) );
            $tr->addContent( Xhtml::td( $error->getException() )->class_( "exception" ) );
            $tbody->addContent( $tr );

            $td = Xhtml::td()->colspan( 4 );
            if ( $error->getBacktrack() )
                $td->addContent( Xhtml::div( Xhtml::span( "Backtrack" ) ) )->addContent(
                        Xhtml::textarea( $error->getBacktrack() )->spellcheck( false )->wrap( false ) )->class_(
                        "backtrack" );
            if ( $error->getTrace() )
                $td->addContent(
                        Xhtml::div( Xhtml::span( "Trace" ) )->addContent(
                                Xhtml::textarea( $error->getTrace() )->spellcheck( false )->wrap( false ) )->class_(
                                "trace" ) );
            if ( $error->getQuery() )
                $td->addContent(
                        Xhtml::div( Xhtml::span( "Query" ) )->addContent(
                                Xhtml::div( HighlighterUtil::highlight( $error->getQuery() ) ) )->class_( "query" ) );
            if ( count( $tr->get_content() ) > 0 )
                $tbody->addContent( Xhtml::tr( $td )->addClass( "extra" ) );

            $table->addContent( $tbody );
        }

        $tfoot = Xhtml::tfoot( Xhtml::tr( Xhtml::td( "No Errors" )->colspan( 4 ) ) )->id( "errors_noerrors" )->class_(
                Resource::css()->getHide() );
        $table->addContent( $tfoot );

        $root->addContent( $table );
    }

    // /FUNCTIONS


}

?>