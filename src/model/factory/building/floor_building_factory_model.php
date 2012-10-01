<?php

class FloorBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param int $buildingId
     * @param string $name
     * @param int $order
     * @param string $coordinates
     * @param boolean $main [false]
     * @return FloorBuildingModel
     */
    public static function createFloorBuilding( $buildingId, $name, $order, $coordinates, $main = false )
    {

        // Initiate model
        $floorBuilding = new FloorBuildingModel();

        $floorBuilding->setOrder( intval( $order ) );
        $floorBuilding->setBuildingId( intval( $buildingId ) );
        $floorBuilding->setName( Core::utf8Encode( $name ) );
        $floorBuilding->setCoordinates(Resource::generateCoordinatesToString( $coordinates ));
        $floorBuilding->setMain( intval( $main ) );

        // Return model
        return $floorBuilding;

    }

    // /FUNCTIONS


}

?>