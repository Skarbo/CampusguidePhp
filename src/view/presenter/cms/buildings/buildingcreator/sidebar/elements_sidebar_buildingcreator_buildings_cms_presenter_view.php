<?php

class ElementsSidebarBuildingcreatorBuildingsCmsPresenterView extends SidebarBuildingcreatorBuildingsCmsPresenterView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::getSidebarGroups()
     */
    protected function getSidebarGroups()
    {
        return "elements";
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::getSidebarType()
     */
    protected function getSidebarType()
    {
        return "elements";
    }

    // ... /GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        $root->addContent( Xhtml::h( 1, "Elements" ) );
        $root->addContent( Xhtml::span( $this->getBuildingElements()->size() ) );
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawContent()
     */
    protected function drawContent( AbstractXhtml $root )
    {
        $table = Xhtml::table()->class_( "elements" );

        // Floors
        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();
            $elements = $this->getBuildingElements()->getFloor( $floor->getId() );

            $tableBody = Xhtml::tbody()->attr( "data-floor", $floor->getId() )->class_( Resource::css()->getHide() );
            for ( $elements->rewind(); $elements->valid(); $elements->next() )
            {
                $element = $elements->current();

                $tableRow = Xhtml::tr()->attr( "data-element", $element->getId() )->class_( "element" );

                // Element id
                $tableRow->addContent(
                        Xhtml::td( sprintf( "#%s", $element->getId() ) )->class_( "id" )->title(
                                sprintf( "Id #%s", $element->getId() ) ) );

                // Element name
                $tableRow->addContent(
                        Xhtml::td( $element->getName() ? $element->getName() : Xhtml::italic( "(Unnamed)" ) )->class_(
                                "name", "show" )->title( "Name" ) );

                // Element name edit
                $tableRow->addContent(
                        Xhtml::td(
                                Xhtml::input( $element->getName(), "element_name" )->placeholder( "Name" )->attr(
                                        "data-value", $element->getName() ) )->class_( "name", "edit",
                                Resource::css()->getHide() )->title( "Name" ) );

                // Element type
                //                 $typesSelect = Xhtml::div()->class_("element_type_dropdown")->attr("data-name", "element_type");
                //                 $typesSelect->addContent( Xhtml::div( Xhtml::img()->src(Resource::image()->icon()->getRoomClassSvg()) )->attr("data-value", "class") );
                //                 $typesSelect->addContent( Xhtml::div( Xhtml::img()->src(Resource::image()->icon()->getRoomAuditoriumSvg()) )->attr("data-value", "auditorium") );
                //                 $tableRow->addContent(Xhtml::td($typesSelect)->addClass("type"));
                $tableRow->addContent(
                        Xhtml::td(
                                Xhtml::img(
                                        $element->getType() ? Resource::image()->icon()->getRoomSvg(
                                                $element->getType() ) : Resource::image()->getEmptyImage(),
                                        $element->getType() )->title( $element->getType() ) )->addClass( "type", "show" ) );

                $typeSelect = Xhtml::select()->name( "element_type" )->attr( "data-value", $element->getType() );
                $typeSelect->addContent( Xhtml::option( "", "" ) );
                foreach ( ElementBuildingModel::$TYPES_ROOM as $typeRoom )
                {
                    $typeSelect->addContent(
                            Xhtml::option( $typeRoom, $typeRoom )->selected( $typeRoom == $element->getType() ) );
                }
                $tableRow->addContent(
                        Xhtml::td( $typeSelect )->addClass( "type", "edit", Resource::css()->getHide() ) );

                $tableBody->addContent( $tableRow );
            }

            if ( $elements->isEmpty() )
            {
                $tableBody->addContent( Xhtml::tr( Xhtml::td( Xhtml::italic( "No elements" ) )->colspan( 4 ) ) );
            }

            $table->addContent( $tableBody );
        }

        // Javascript element room type
        $javascriptViewClass = $this->getController()->getJavascriptView();
        $scriptElementTypeImgs = Xhtml::script( sprintf( "%s.ELEMENT_TYPE_ROOMS = {};\n", $javascriptViewClass ) )->addContent(
                implode( "\n",
                        array_map(
                                function ( $type ) use($javascriptViewClass )
                                {
                                    return sprintf( "%s.ELEMENT_TYPE_ROOMS.%s = '%s';", $javascriptViewClass, $type,
                                            Resource::image()->icon()->getRoomSvg( $type ) );
                                }, array_merge( ElementBuildingModel::$TYPES_ROOM, array ( "empty" ) ) ) ) )->type(
                ScriptXhtml::$TYPE_JAVASCRIPT );

        $root->addContent( $scriptElementTypeImgs );
        $root->addContent( $table );
        // Test
    }

    // /FUNCTIONS


}

?>