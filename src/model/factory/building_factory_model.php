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
     * @param mixed $address Array( "streetname", "city", "postal", "country" )|String("streetname|city|postal|country")
     * @param mixed $position Array( Array( lat, lon ), ... )|String( "lat,lon|...", ... )
     * @param mixed $location Array( lat, lon )|String( "lat,lon" )
     * @return BuildingModel
     */
    public static function createBuilding( $name, $facilityId, $address = array(), $position = array(), $location = array(), $overlay = array() )
    {

        // Initiate model
        $building = new BuildingModel();

        $building->setName( Core::utf8Encode( $name ) );
        $building->setFacilityId( intval( $facilityId ) );
        $building->setAddress( Core::utf8Encode( is_array( $address ) ? $address : explode( "|", $address ) ) );
        $building->setPosition( BuildingUtil::generatePositionToArray( $position ) );
        $building->setLocation( BuildingUtil::generateLocationToArray( $location ) );
        $building->setOverlay( is_array( $overlay ) ? $overlay : json_decode( $overlay, true ) );

        // Return model
        return $building;

    }

    // /FUNCTIONS


}

?>