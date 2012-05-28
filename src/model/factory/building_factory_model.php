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
     * @param mixed $address Array( "streetname", "city", "postal", "country" )|String("streetname|city|postal|country")
     * @param mixed $position Array( Array( lat, lon ), ... )|String( "lat,lon|..." )
     * @return BuildingModel
     */
    public static function createBuilding( $name, $facilityId, $coordinates, $address = array(), $position = array() )
    {

        // Initiate model
        $building = new BuildingModel();

        $building->setName( Core::utf8Encode( $name ) );
        $building->setFacilityId( intval( $facilityId ) );
        $building->setCoordinates( Resource::generateCoordinatesToArray( $coordinates ) );
        $building->setAddress( Core::utf8Encode( is_array( $address ) ? $address : explode( "|", $address ) ) );
        $building->setPosition( BuildingUtil::generatePositionToArray( $position ) );

        // Return model
        return $building;

    }

    // /FUNCTIONS


}

?>