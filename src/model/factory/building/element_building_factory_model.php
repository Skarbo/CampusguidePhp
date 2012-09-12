<?php

class ElementBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $floorId
     * @param string $name
     * @param mixed $coordinates Array( Array( x, y ) ) | String( "x,y|x,y" )
     * @param int $typeId
     * @param int $sectionId
     * @return ElementBuildingModel
     */
    public static function createElementBuilding( $floorId, $name, $coordinates, $typeId, $sectionId )
    {

        // Initiate model
        $elementBuilding = new ElementBuildingModel();

        $elementBuilding->setFloorId( intval( $floorId ) );
        $elementBuilding->setName( Core::utf8Encode( $name ) );
        $elementBuilding->setCoordinates( Resource::generateCoordinatesToArray( $coordinates ) );
        $elementBuilding->setTypeId( intval( $typeId ) );
        $elementBuilding->setSectionId( intval( $sectionId ) );

        // Return model
        return $elementBuilding;

    }

    // /FUNCTIONS


}

?>