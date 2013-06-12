<?php

class ElementsSidebarBuildingcreatorBuildingsCmsPresenterView extends PresenterView
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

    }

    public static function drawElementType( AbstractXhtml $root, $elementType, $elementTypeGroup, FloorBuildingListModel $buildingFloors, ElementBuildingListModel $buildingElements )
    {
        $wrapper = Xhtml::div()->class_( "element_group_wrapper", Resource::css()->getHide() )->attr(
                "data-element-type", $elementType );

        // Room type header
        $typeGroupHeader = Xhtml::div()->class_( "type_group_header_wrapper" );
        $typeGroupHeader->addContent(
                Xhtml::div(
                        Xhtml::img(
                                Resource::image()->building()->element()->getType( $elementType, "#333333", "#333333" ) ) ) );
        $typeGroupHeader->addContent(
                Xhtml::h( 2, DefaultLocale::instance()->building()->element()->getType( $elementType ) ) );
        $wrapper->addContent( $typeGroupHeader );

        $table = Xhtml::table()->class_( "elements_table" );

        // Floors
        for ( $buildingFloors->rewind(); $buildingFloors->valid(); $buildingFloors->next() )
        {
            $floor = $buildingFloors->current();

            $floorId = $floor->getId();
            $elements = $buildingElements->filter(
                    function ( ElementBuildingModel $element ) use($floorId, $elementType, $elementTypeGroup )
                    {
                        return $element->getFloorId() == $floorId && $element->getType() == $elementType && $element->getTypeGroup() == $elementTypeGroup;
                    } );

            self::drawElementTypeFloor( $table, $floor, $elements );
        }

        $wrapper->addContent( $table );
        $root->addContent( $wrapper );
    }

    private static function drawElementTypeFloor( AbstractXhtml $table, FloorBuildingModel $floor, ElementBuildingListModel $elements )
    {
        $tableBody = Xhtml::tbody()->attr( "data-floor", $floor->getId() )->class_( Resource::css()->getHide() );
        for ( $elements->rewind(); $elements->valid(); $elements->next() )
        {
            $element = $elements->current();
            self::drawElementTypeFloorElement( $tableBody, $element );
        }

        if ( $elements->isEmpty() )
        {
            $tableBody->addContent( Xhtml::tr( Xhtml::td( Xhtml::italic( "No elements" ) )->colspan( 4 ) ) );
        }

        $table->addContent( $tableBody );
    }

    private static function drawElementTypeFloorElement( AbstractXhtml $tableBody, ElementBuildingModel $element )
    {
        $tableRow = Xhtml::tr()->attr( "data-element", $element->getId() )->attr("data-element-type", $element->getType() )->attr("data-element-type-group", $element->getTypeGroup() )->attr("data-element-edit", "true")->class_( "element" );

        // Element id
        $tableRow->addContent(
                Xhtml::td( sprintf( "#%s", $element->getId() ) )->class_( "id" )->title(
                        sprintf( "Id #%s", $element->getId() ) ) );

        // Element type
        $elementTypeInput = Xhtml::input( $element->getType(), "element_type" )->type(
                InputXhtml::$TYPE_HIDDEN )->attr( "data-value", $element->getType() );

        // Element name
        $elementNameDiv = Xhtml::div(
                Xhtml::input( $element->getName(), "element_name" )->placeholder( "Name" )->readonly( true )->attr(
                        "data-value", $element->getName() ) )->class_( "input_wrapper" );

        // Element name edit
        $tableRow->addContent(
                Xhtml::td( $elementNameDiv )->addContent( $elementTypeInput )->class_( "name" )->title( "Name" ) );

        // Element infopanel
        $elementInforpanelDiv = Xhtml::div(
                Xhtml::img( Resource::image()->icon()->getOptionsSvg( "#333333", "#333333" ) ) );
        $tableRow->addContent( Xhtml::td( $elementInforpanelDiv )->class_( "infopanel" )->title( "Infopanel" ) );

        // Element focus
        $elementInforpanelDiv = Xhtml::div(
                Xhtml::img( Resource::image()->icon()->getSearchSvg( "#333333", "#333333" ) ) );
        $tableRow->addContent( Xhtml::td( $elementInforpanelDiv )->class_( "focus" )->title( "Focus" ) );

        $tableBody->addContent( $tableRow );
    }

    public static function drawInfoPanelName()
    {
        $table = Xhtml::table()->class_( "element_name_table" );
        $row = Xhtml::tr()->class_( "element_name_input_wrapper", "template" );
        $row->addContent(
                Xhtml::td(
                        Xhtml::div( Xhtml::input( "", "element_name" )->placeholder( "Name" ) )->class_( "input_wrapper" ) ) );
        $row->addContent( Xhtml::td( Xhtml::a( Xhtml::img(Resource::image()->icon()->getCrossSvg("#333333", "#333333"), "Remove"), "#" )->title("Remove")->class_( "element_name_remove" ) ) );
        $table->addContent( $row );

        $elementNameContent = Xhtml::div()->class_( "element_name_wrapper" );
        $elementNameContent->addContent( $table );
        $elementNameContent->addContent( Xhtml::a( "Add name", "#" )->class_( "element_name_add" ) );

        $elementNameContent->addContent( Xhtml::input( "", "element_id" )->type( InputXhtml::$TYPE_HIDDEN ) );

        return $elementNameContent;
    }

    // /FUNCTIONS


}

?>