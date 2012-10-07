<?php

class ElementsSidebarBuildingcreatorBuildingsCmsPresenterView extends SidebarBuildingcreatorBuildingsCmsPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        $sidebar = Xhtml::div()->class_( "sidebar elements" )->attr( "data-sidebar", "elements" )->attr(
                "data-sidebar-group", "elements" );

        // Header
        $header = Xhtml::div()->class_( Resource::css()->getTable(), "sidebar_header_wrapper", "collapse" );
        $header->addContent( Xhtml::h( 1, "Elements" ) );
        $header->addContent( Xhtml::span( $this->getBuildingElements()->size() ) );

        // Content
        $content = Xhtml::div()->class_( "content" );

        $table = Xhtml::table()->class_( "elements" );

        // Floors
        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();
            $elements = $this->getBuildingElements()->getFloor( $floor->getId() );

            $tableBody = Xhtml::tbody()->attr( "data-floor", $floor->getId() )->class_(Resource::css()->getHide());
            for ( $elements->rewind(); $elements->valid(); $elements->next() )
            {
                $element = $elements->current();

                $tableRow = Xhtml::tr()->attr( "data-element", $element->getId() )->class_("element");

                // Element id
                $tableRow->addContent( Xhtml::td( sprintf( "#%s", $element->getId() ) )->class_( "id" )->title( sprintf( "Id #%s", $element->getId() ) ) );

                // Element name
                $tableRow->addContent(
                        Xhtml::td( $element->getName() ? $element->getName() : Xhtml::italic("(Unnamed)") )->class_( "name", "show" )->title( "Name" ) );

                // Element name edit
                $tableRow->addContent(
                        Xhtml::td(
                                Xhtml::input( $element->getName(), "element_name" )->placeholder( "Name" )->attr(
                                        "data-value", $element->getName() ) )->class_( "name", "edit", Resource::css()->getHide() )->title( "Name" ) );

                $tableBody->addContent( $tableRow );
            }

            if ( $elements->isEmpty() )
            {
                $tableBody->addContent( Xhtml::tr( Xhtml::td( Xhtml::italic( "No elements" ) )->colspan(4) ) );
            }

            $table->addContent( $tableBody );
        }

        $content->addContent( $table );

        $sidebar->addContent( $header );
        $sidebar->addContent( $content );

        $root->addContent( $sidebar );

    }

    // /FUNCTIONS


}

?>