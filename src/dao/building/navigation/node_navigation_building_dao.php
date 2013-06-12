<?php

interface NodeNavigationBuildingDao extends StandardDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param integer $buildingId
     * @return NodeNavigationBuildingListModel Naivgation Nodes for given Building
     */
    public function getBuilding( $buildingId );

    /**
     * @param integer $elementId
     * @return NodeNavigationBuildingModel Navigation Node for given Element
     */
    public function getElement( $elementId );

    /**
     * @param integer $nodeLeft Node id
     * @param integer $nodeRight Node id
     * @return boolean True if added or updated
     */
    public function addEdge( $nodeLeft, $nodeRight );

    /**
     * @param integer $nodeLeft Node id
     * @param integer $nodeRight Node id
     * @return boolean True if has edge
     */
    public function hasEdge( $nodeLeft, $nodeRight );

    /**
     * Remove Floor Edges
     *
     * @param integer $floorId
     * @return integer Number of removed edges
     */
    public function removeEdges( $floorId );

    // /FUNCTIONS


}

?>