<?php

class ElementBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return ElementBuildingModel
     */
    public static function createElementBuilding( $floorId, $name, $coordinates, $sectionId, $type = "", $typeGroup = "", $deleted = false )
    {

        // Initiate model
        $elementBuilding = new ElementBuildingModel();

        $elementBuilding->setFloorId( intval( $floorId ) );
        $elementBuilding->setName( Core::utf8Encode( $name ) );
        $elementBuilding->setCoordinates( Resource::generateCoordinatesToString( $coordinates ) );
        $elementBuilding->setType( $type );
        $elementBuilding->setTypeGroup( $typeGroup );
        $elementBuilding->setSectionId( intval( $sectionId ) );
        $elementBuilding->setDeleted( ( boolean ) $deleted );

        // Return model
        return $elementBuilding;

    }

    // /FUNCTIONS


}

?>