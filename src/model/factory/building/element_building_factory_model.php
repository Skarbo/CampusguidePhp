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
     * @param string $coordinates
     * @param int $typeId
     * @param int $sectionId
     * @param boolean $deleted
     * @return ElementBuildingModel
     */
    public static function createElementBuilding( $floorId, $name, $coordinates, $typeId, $sectionId, $deleted = false )
    {

        // Initiate model
        $elementBuilding = new ElementBuildingModel();

        $elementBuilding->setFloorId( intval( $floorId ) );
        $elementBuilding->setName( Core::utf8Encode( $name ) );
        $elementBuilding->setCoordinates( $coordinates );
        $elementBuilding->setTypeId( intval( $typeId ) );
        $elementBuilding->setSectionId( intval( $sectionId ) );
        $elementBuilding->setDeleted( (boolean) $deleted );

        // Return model
        return $elementBuilding;

    }

    // /FUNCTIONS


}

?>