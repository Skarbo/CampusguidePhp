<?php

class BuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $name
     * @param int $facilityId
     * @param mixed $coordinates Array( Array( x, y ) )|String(x,y|x,y)
     * @param string $location
     * @param mixed $address Array( "streetname", "city", "postal", "country" )|String("streetname|city|postal|country")
     * @return BuildingModel
     */
    public static function createBuilding( $name, $facilityId, $coordinates, $location = "", array $address = array() )
    {

        // Initiate model
        $building = new BuildingModel();

        $building->setName( Core::utf8Encode( $name ) );
        $building->setFacilityId( intval( $facilityId ) );
        $building->setCoordinates( Resource::generateCoordinatesToArray( $coordinates ) );
        $building->setLocation( $location );
        $building->setAddress(
                Core::utf8Encode( is_array( $address ) ? $address : explode( "|", $address ) ) );

        // Return model
        return $building;

    }

    // /FUNCTIONS


}

?>