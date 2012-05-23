<?php

class TypeElementBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    /**
     * @param int $groupId
     * @param string $name
     * @param string $icon
     * @return TypeElementBuildingModel
     */
    public static function createTypeElementBuilding( $groupId, $name, $icon = "" )
    {

        // Initiate model
        $typeElementBuilding = new TypeElementBuildingModel();

		$typeElementBuilding->setGroupId( intval( $groupId ) );
		$typeElementBuilding->setName( Core::utf8Encode( $name ) );
		$typeElementBuilding->setIcon( strval( $icon ) );

        // Return model
        return $typeElementBuilding;

    }

    // /FUNCTIONS


}

?>