<?php

class SectionBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $buildingId
     * @param string $name
     * @param string $coordinates
     * @return SectionBuildingModel
     */
    public static function createSectionBuilding( $buildingId, $name, $coordinates )
    {

        // Initiate model
        $sectionBuilding = new SectionBuildingModel();

        $sectionBuilding->setBuildingId( intval( $buildingId ) );
        $sectionBuilding->setName( Core::utf8Encode( $name ) );
        $sectionBuilding->setCoordinates( Resource::generateCoordinatesToArray( $coordinates ) );

        // Return model
        return $sectionBuilding;

    }

    // /FUNCTIONS


}

?>