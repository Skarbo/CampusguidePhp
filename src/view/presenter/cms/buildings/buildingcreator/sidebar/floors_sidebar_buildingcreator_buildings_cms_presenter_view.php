<?php

class FloorsSidebarBuildingcreatorBuildingsCmsPresenterView extends SidebarBuildingcreatorBuildingsCmsPresenterView
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
        return "floors elements navigation";
    }

    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::getSidebarType()
     */
    protected function getSidebarType()
    {
        return "floors";
    }

    // ... /GET


    /**
     * @see SidebarBuildingcreatorBuildingsCmsPresenterView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        $root->addContent( Xhtml::h( 1, "Floors" ) );
        $root->addContent( Xhtml::span( $this->getBuildingFloors()->size() ) );
    }

    protected function drawContent( AbstractXhtml $root )
    {
        $root->id( "buildingcreator_planner_sidebar_floors" );

        // Floor form
        $floorForm = Xhtml::form()->method( FormXhtml::$METHOD_POST )->action(
                Resource::url()->cms()->building()->getBuildingcreatorEditFloorsPage( $this->getBuilding()->getId(),
                        $this->getView()->getMode() ) )->autocomplete( false )->enctype(
                FormXhtml::$ENCTYPE_MULTIPART_FORM_DATA )->id( "floors_form" );

        $floorTable = Xhtml::table()->class_( "floors" );
        $floorsBody = Xhtml::tbody();
        $floorsBodyNoFloors = Xhtml::tbody()->class_( "floors_none" );
        $floorsFootNewFloor = Xhtml::tfoot()->class_( "floor_new" );

        // Each Floors
        for ( $this->getBuildingFloors()->rewind(); $this->getBuildingFloors()->valid(); $this->getBuildingFloors()->next() )
        {
            $floor = $this->getBuildingFloors()->current();
            $this->drawFloorsRow( $floorsBody, $floor );
        }

        // No floors
        if ( $this->getBuildingFloors()->isEmpty() )
        {
            $floorsBodyNoFloors->addContent( Xhtml::tr( Xhtml::td( "No floors" )->colspan( 5 ) ) );
        }

        // New floor
        $this->drawFloorsRow( $floorsFootNewFloor, null );

        // Floors error
        $floorsError = Xhtml::div()->class_( Resource::css()->cms()->getError() )->id( "floors_error" );

        // Floor buttons
        $floorButtons = Xhtml::div()->class_( "floor_buttons", Resource::css()->gui()->getGui(), "theme4",
                Resource::css()->getHide() );
        $floorButtons->addContent(
                Xhtml::div( "Cancel" )->id( "floors_cancel" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->gui()->getButton() )->attr( "data-disabled", "true" ) );
        $floorButtons->addContent(
                Xhtml::div( "Apply" )->id( "floors_apply" )->class_( Resource::css()->gui()->getComponent(),
                        Resource::css()->gui()->getButton() )->attr( "data-disabled", "true" ) );

        $floorTable->addContent( $floorsBody );
        $floorTable->addContent( $floorsBodyNoFloors );
        $floorTable->addContent( $floorsFootNewFloor );

        $floorForm->addContent( $floorTable );
        $floorForm->addContent( $floorsError );
        $floorForm->addContent( $floorButtons );
        $root->addContent( $floorForm );
    }

    /**
     * @param AbstractXhtml $root
     * @param FloorBuildingModel $floor
     */
    private function drawFloorsRow( AbstractXhtml $root, FloorBuildingModel $floor )
    {
        $isNew = $floor == null;

        $row = Xhtml::tr()->class_( "floor", $isNew ? Core::cc(" ", "edit", Resource::css()->getHide() ) : "" )->attr( "data-floor", !$isNew ? $floor->getId() : "new" );

        $floorDelete = Xhtml::td( Xhtml::$NBSP )->class_( "delete" )->title( "Delete" );
        $floorName = Xhtml::td()->class_( "name" )->title( "Name" );
        $floorMap = Xhtml::td( Xhtml::$NBSP )->class_( "map" )->title( "Map" );
        $floorOrder = Xhtml::td( Xhtml::$NBSP )->class_( "order", Resource::css()->getRight() )->title( "Order" );
        $floorMain = Xhtml::td()->class_( "main", Resource::css()->getRight() )->title( "Main" );

        // Floor name
        $floorName->addContent(
                Xhtml::input( $isNew ? "" : $floor->getName(), sprintf( "floor_name[%s]", $isNew ? "new" : $floor->getId() ) )->placeholder( "Name" )->title(
                        "Name" )->class_( "edit", Resource::css()->getHide() ) );

        // Floor map
        $floorMap->content(
                Xhtml::div(
                        Xhtml::div( Xhtml::div()->attr( "data-icon", "map" ) )->attr( "data-type", "file" )->attr(
                                "data-name", sprintf( "floor_map[%s]", !$isNew ? $floor->getId() : "new" ) )->class_(
                                Resource::css()->gui()->getComponent() ) )->class_( Resource::css()->gui()->getGui(),
                        "edit", Resource::css()->getHide() ) );

        // Floor main
        $floorMain->addContent(
                Xhtml::div( !$isNew && $floor->getMain() ? Xhtml::div()->attr( "data-icon", "star" ) : "" )->class_( "show" ) );
        $floorMain->addContent(
                Xhtml::div(
                        Xhtml::div( Xhtml::div()->attr( "data-icon", "star" ) )->attr( "data-type", "radio" )->attr(
                                "data-radio-name", "floor_main" )->attr( "data-value", !$isNew ? $floor->getId() : "new" )->class_(
                                        Resource::css()->gui()->getComponent(), !$isNew && $floor->getMain() ? "checked" : "" ) )->class_(
                                                Resource::css()->gui()->getGui(), "edit", Resource::css()->getHide() ) );

        if ( !$isNew )
        {
            // Floor delete
            $floorDelete->content(
                    Xhtml::div(
                            Xhtml::div( Xhtml::div()->attr( "data-icon", "cross" ) )->attr( "data-type", "toggle" )->attr(
                                    "data-name", "floor_delete[]" )->attr( "data-value", $floor->getId() )->class_(
                                    Resource::css()->gui()->getComponent() ) )->class_( Resource::css()->gui()->getGui(),
                            "edit", Resource::css()->getHide() ) );

            // Floor name
            $floorName->addContent( Xhtml::div( $floor->getName() )->class_( "show" ) );

            // Floor order
            $floorOrder->content(
                    Xhtml::div( Xhtml::div()->attr( "data-icon", "up" )->class_( "up" )->title( "Order up" ) )->addContent(
                            Xhtml::div()->attr( "data-icon", "down" )->class_( "down" )->title( "Order down" ) )->addContent(
                            Xhtml::input( $floor->getOrder(), sprintf( "floor_order[%s]", $floor->getId() ) ) )->class_(
                            "edit", Resource::css()->getHide() ) );
        }

        $row->addContent( $floorDelete );
        $row->addContent( $floorName );
        $row->addContent( $floorMap );
        $row->addContent( $floorOrder );
        $row->addContent( $floorMain );

        $root->addContent( $row );
    }

    // /FUNCTIONS


}

?>