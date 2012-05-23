<?php

class ElementBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $buildingId
     * @param string $name
     * @param mixed $coordinates Array( Array( x, y ) ) | String( "x,y|x,y" )
     * @param int $typeId
     * @param int $floorId
     * @param int $sectionId
     * @return ElementBuildingModel
     */
    public static function createElementBuilding( $buildingId, $name, $coordinates, $typeId, $floorId, $sectionId )
    {

        // Initiate model
        $elementBuilding = new ElementBuildingModel();

        $elementBuilding->setBuildingId( intval( $buildingId ) );
        $elementBuilding->setName( Core::utf8Encode( $name ) );
        $elementBuilding->setCoordinates( Resource::generateCoordinatesToArray( $coordinates ) );
        $elementBuilding->setTypeId( intval( $typeId ) );
        $elementBuilding->setFloorId( intval( $floorId ) );
        $elementBuilding->setSectionId( intval( $sectionId ) );

        // Return model
        return $elementBuilding;

    }

    // /FUNCTIONS


}

?>