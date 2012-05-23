<?php

class FacilityFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return FacilityModel
     */
    public static function createFacility( $name )
    {

        // Initiate model
        $facility = new FacilityModel();

        $facility->setName( Core::utf8Encode( $name ) );

        // Return model
        return $facility;

    }

    // /FUNCTIONS


}

?>