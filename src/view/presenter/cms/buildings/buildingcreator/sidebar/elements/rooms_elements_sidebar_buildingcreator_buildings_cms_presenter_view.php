<?php

class RoomsElementsSidebarBuildingcreatorBuildingsCmsPresenterView extends SidebarBuildingcreatorBuildingsCmsPresenterView
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
        return "elements_rooms";
    }

    // ... /GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        $root->addContent(
                Xhtml::div( Xhtml::img( Resource::image()->building()->element()->getElements( "#666666" ), "Room" ) ) );
        $root->addContent( Xhtml::h( 1, "Rooms" ) );
        $root->addContent( Xhtml::span( $this->getBuildingElements()->size() ) );
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawContent()
     */
    protected function drawContent( AbstractXhtml $root )
    {
        $root->id( "buildingcreator_planner_sidebar_elements_rooms" );

        // JAVASCRIPT


        // Javascript element room type
        $javascriptViewClass = $this->getController()->getJavascriptView();
        //         $scriptElementTypeImgs = Xhtml::script( sprintf( "%s.ELEMENT_TYPE_ROOMS = {};\n", $javascriptViewClass ) )->addContent(
        //                 implode( "\n",
        //                         array_map(
        //                                 function ( $type ) use($javascriptViewClass )
        //                                 {
        //                                     return sprintf( "%s.ELEMENT_TYPE_ROOMS.%s = '%s';", $javascriptViewClass, $type,
        //                                             Resource::image()->building()->element()->getType( $type ) );
        //                                 }, array_merge( ElementBuildingModel::$TYPES_ROOM, array ( "none" ) ) ) ) )->type(
        //                 ScriptXhtml::$TYPE_JAVASCRIPT );


        $scriptElementTypeImgs = array ();
        foreach ( ElementBuildingModel::$TYPES_ROOM as $typeRoom )
        {
            $scriptElementTypeImgs[ $typeRoom ] = array (
                    "name" => $this->getLocale()->building()->element()->getType( $typeRoom ),
                    "source" => Resource::image()->building()->element()->getType( $typeRoom, "#333333", "#333333" ) );
        }

        $root->addContent(
                Xhtml::script(
                        sprintf( "%s.ELEMENT_TYPE_ROOMS = %s;\n", $javascriptViewClass,
                                json_encode( $scriptElementTypeImgs ) ) )->type( ScriptXhtml::$TYPE_JAVASCRIPT ) );

        // /JAVASCRIPT

        ElementsSidebarBuildingcreatorBuildingsCmsPresenterView::drawElementType( $root, "",
                ElementBuildingModel::TYPE_GROUP_ROOM, $this->getBuildingFloors(), $this->getBuildingElements() );

        foreach ( ElementBuildingModel::$TYPES_ROOM as $roomType )
        {
            ElementsSidebarBuildingcreatorBuildingsCmsPresenterView::drawElementType( $root, $roomType,
                    ElementBuildingModel::TYPE_GROUP_ROOM, $this->getBuildingFloors(), $this->getBuildingElements() );
        }

        $this->drawElementTypeSelecter( $root );
        $this->drawInfoPanel();
    }

    private function drawRoomType( AbstractXhtml $root, $roomType )
    {
        $wrapper = Xhtml::div()->class_( "room_wrapper", Resource::css()->getHide() )->attr( "data-room-type",
                $roomType );

        // Room type header
        $typeGroupHeader = Xhtml::div()->class_( "type_group_header_wrapper" );
        $typeGroupHeader->addContent(
                Xhtml::div(
                        Xhtml::img(
                                Resource::image()->building()->element()->getType( $roomType, "#333333", "#333333" ) ) ) );
        $typeGroupHeader->addContent( Xhtml::h( 2, $this->getLocale()->building()->element()->getType( $roomType ) ) );
        $wrapper->addContent( $typeGroupHeader );

        $table = Xhtml::table()->class_( "elements_rooms" );

        // Floors
        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();

            $floorId = $floor->getId();
            $elements = $this->getBuildingElements()->filter(
                    function ( ElementBuildingModel $element ) use($floorId, $roomType )
                    {
                        return $element->getFloorId() == $floorId && $element->getType() == $roomType && $element->getTypeGroup() == ElementBuildingModel::TYPE_GROUP_ROOM;
                    } );

            $this->drawRoomTypeFloor( $table, $floor, $elements );
        }

        $wrapper->addContent( $table );
        $root->addContent( $wrapper );
    }

    private function drawRoomTypeFloor( AbstractXhtml $table, FloorBuildingModel $floor, ElementBuildingListModel $elements )
    {
        $tableBody = Xhtml::tbody()->attr( "data-floor", $floor->getId() )->class_( Resource::css()->getHide() );
        for ( $elements->rewind(); $elements->valid(); $elements->next() )
        {
            $element = $elements->current();
            $this->drawRoomTypeFloorRoom( $tableBody, $element );
        }

        if ( $elements->isEmpty() )
        {
            $tableBody->addContent( Xhtml::tr( Xhtml::td( Xhtml::italic( "No elements" ) )->colspan( 4 ) ) );
        }

        $table->addContent( $tableBody );
    }

    private function drawRoomTypeFloorRoom( AbstractXhtml $tableBody, ElementBuildingModel $element )
    {
        $tableRow = Xhtml::tr()->attr( "data-element", $element->getId() )->attr("data-element-edit", "true")->class_( "element" );

        // Element id
        $tableRow->addContent(
                Xhtml::td( sprintf( "#%s", $element->getId() ) )->class_( "id" )->title(
                        sprintf( "Id #%s", $element->getId() ) ) );

        // Element ype
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
        $elementInforpanelDiv = Xhtml::div( Xhtml::img( Resource::image()->icon()->getOptionsSvg("#333333", "#333333") ) );
        $tableRow->addContent(
                Xhtml::td( $elementInforpanelDiv )->class_( "infopanel" )->title( "Infopanel" ) );

        // Element focus
        $elementInforpanelDiv = Xhtml::div( Xhtml::img( Resource::image()->icon()->getSearchSvg("#333333", "#333333") ) );
        $tableRow->addContent(
                Xhtml::td( $elementInforpanelDiv )->class_( "focus" )->title( "Focus" ) );


        // Element type
        //         $elementTypeImage = $element->getType() ? Resource::image()->building()->element()->getType(
        //                 $element->getType() ) : Resource::image()->getEmptyImage();
        //         $elementTypeName = $this->getLocale()->building()->element()->getType( $element->getType() );
        //         $elementTypeInput = Xhtml::input( $element->getType(), "element_type" )->type( InputXhtml::$TYPE_HIDDEN )->attr(
        //                 "data-value", $element->getType() );
        //         $elementTypeGroupInput = Xhtml::input( $element->getTypeGroup(), "element_type_group" )->type(
        //                 InputXhtml::$TYPE_HIDDEN )->attr( "data-value", $element->getTypeGroup() );
        //         $elementTypeWrapper = Xhtml::div( Xhtml::img( $elementTypeImage, $elementTypeName )->title( $elementTypeName ) )->class_(
        //                 "element_type_image_wrapper" );
        //         $tableRow->addContent(
        //                 Xhtml::td( $elementTypeWrapper )->addContent( $elementTypeInput, $elementTypeGroupInput )->addClass(
        //                         "type" ) );


        $tableBody->addContent( $tableRow );
    }

    private function drawElementTypeSelecter( AbstractXhtml $root )
    {

        $wrapper = Xhtml::div()->id( "element_type_selecter" )->attr("data-element-edit", "true");

        $wrapper->addContent( Xhtml::div( Xhtml::$NBSP )->class_( "triangle", "arrow" )->attr("data-arrow", "left") );

        $roomNameContent = Xhtml::div()->class_( "element_type_selecter_content" );

        foreach ( ElementBuildingModel::$TYPE_GROUPS as $typeGroup )
        {
            $typeGroupHeaderWrapper = Xhtml::div()->class_( "type_group_header_wrapper" );
            $typeGroupHeaderWrapper->addContent(
                    Xhtml::h( 3, $this->getLocale()->building()->element()->getTypeGroup( $typeGroup ) ) );
            $typeGroupHeaderWrapper->addContent(
                    Xhtml::div( Xhtml::img( Resource::image()->building()->element()->getTypeGroup( $typeGroup ) ) ) );

            $roomNameContent->addContent( $typeGroupHeaderWrapper );

            $types = Core::arrayAt( ElementBuildingModel::$TYPES, $typeGroup, array () );
            sort( $types );
            foreach ( $types as $type )
            {
                $elementTypeName = $this->getLocale()->building()->element()->getType( $type );
                $elementTypeWrapper = Xhtml::div()->class_( "type_wrapper" );
                $elementTypeWrapper->addContent(
                        Xhtml::div( $this->getLocale()->building()->element()->getType( $type ) ) );
                $elementTypeWrapper->addContent(
                        Xhtml::div(
                                Xhtml::img( Resource::image()->building()->element()->getType( $type ),
                                        $elementTypeName )->title( $elementTypeName ) )->class_(
                                "element_type_image_wrapper" ) );
                $elementTypeWrapper->attr( "data-type", $type );
                $elementTypeWrapper->attr( "data-type-group", $typeGroup );

                $roomNameContent->addContent( $elementTypeWrapper );
            }
        }

        $wrapper->addContent( $roomNameContent );
        $root->addContent( $wrapper );

    }

    private function drawInfoPanel()
    {

//         // ROOM NAME


//         $table = Xhtml::table()->class_( "room_name_table" );
//         $row = Xhtml::tr()->class_( "room_name_input_wrapper", "template" );
//         $row->addContent(
//                 Xhtml::td(
//                         Xhtml::div( Xhtml::input( "", "room_name" )->placeholder( "Name" ) )->class_( "input_wrapper" ) ) );
//         $row->addContent( Xhtml::td( Xhtml::button( "Remove" )->class_( "room_name_remove" ) ) );
//         $table->addContent( $row );

//         $roomNameContent = Xhtml::div()->class_( "room_name_wrapper" );
//         $roomNameContent->addContent( $table );
//         $roomNameContent->addContent( Xhtml::a( "Add name", "#" )->class_( "room_name_add" ) );

//         $roomNameContent->addContent( Xhtml::input( "", "room_id" )->type( InputXhtml::$TYPE_HIDDEN ) );

//         $this->addInfoPanelContent( "room_name", "room", "Name", $roomNameContent );

        // /ROOM NAME


        // ROOM TYPE


        $roomTypeContent = Xhtml::div()->class_( "room_type_wrapper" );

        $roomTypeContent->addContent( Xhtml::input( "", "room_type" )->type( InputXhtml::$TYPE_HIDDEN ) );

        foreach ( ElementBuildingModel::$TYPES_ROOM as $typeRoom )
        {

            $roomTypeTitle = $this->getLocale()->building()->element()->getType( $typeRoom );
            $roomTypeContent->addContent(
                    Xhtml::div(
                            Xhtml::img(
                                    Resource::image()->building()->element()->getType( $typeRoom, "#333333", "#333333" ),
                                    $roomTypeTitle ) )->addContent( $roomTypeTitle )->class_( "room_type_content" )->attr(
                            "data-room-type", $typeRoom ) );

        }

        $this->addInfoPanelContent( "room_type", "room", "Type", $roomTypeContent );

        // /ROOM TYPE


    }

    // /FUNCTIONS


}

?>