<?php

class GroupTypeElementBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param string $name
     * @return GroupTypeElementBuildingModel
     */
    public static function createGroupTypeElementBuilding( $name )
    {

        // Initiate model
        $groupTypeElementBuilding = new GroupTypeElementBuildingModel();

        $groupTypeElementBuilding->setName( Core::utf8Encode( $name ) );

        // Return model
        return $groupTypeElementBuilding;

    }

    // /FUNCTIONS


}

?>