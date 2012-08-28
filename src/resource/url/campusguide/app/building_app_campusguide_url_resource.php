<?php

class BuildingAppCampusguideUrlResource extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS

    private static function getController( $mode = null, $url = "" )
    {
        return AppCampusguideUrlResource::getController( BuildingAppCampusguideMainController::$CONTROLLER_NAME,
                $mode, $url );
    }

    public function getBuilding( $id, $mode = null, $url = "" )
    {
        return self::getController( $mode, sprintf( "/%s%s", $id, $url ) );
    }

    // /FUNCTIONS


}

?>