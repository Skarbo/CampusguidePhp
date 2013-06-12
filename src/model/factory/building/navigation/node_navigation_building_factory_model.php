<?php

class NodeNavigationBuildingFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param mixed $edges Array( node, ... )|String("node,...")
     * @param mixed $coordinate Array( x, y )|String("{ x, y }")
     *
     * @return NodeNavigationBuildingModel
     */
    public static function createNodeNavigationBuilding( $floorId, $coordinate, $elementId = null, $edges = array() )
    {

        // Initiate model
        $nodeNavigationBuilding = new NodeNavigationBuildingModel();

        $nodeNavigationBuilding->setFloorId( intval( $floorId ) );
        $nodeNavigationBuilding->setElementId( is_numeric( $elementId ) ? intval( $elementId ) : null );
        $nodeNavigationBuilding->setCoordinate( Resource::generateCoordinatesToArray( $coordinate ) );
        $nodeNavigationBuilding->setEdges(
                is_array( $edges ) ? $edges : $edges != "" ? array_map( function ( $var )
                {
                    return round( $var, 1 );
                }, explode( NodeNavigationBuildingModel::$EDGES_SPLIT, $edges ) ) : array() );

        // Return model
        return $nodeNavigationBuilding;

    }

    // /FUNCTIONS


}

?>