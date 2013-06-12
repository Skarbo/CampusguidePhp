<?php

class NavigationBuildingHandler extends Handler
{

    // VARIABLES


    const NODE_X = "x";
    const NODE_Y = "y";
    const NODE_ID = "nodeId";
    const NODE_ELEMENT = "elementId";
    const NODE_DELETED = "deleted";

    /**
     * @var DaoContainer
     */
    private $daoContainer;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return DaoContainer
     */
    public function getDaoContainer()
    {
        return $this->daoContainer;
    }

    /**
     * @param DaoContainer $daoContainer
     */
    public function setDaoContainer( DaoContainer $daoContainer )
    {
        $this->daoContainer = $daoContainer;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param integer nodesList id
     * @param array anchorArrayArray( id => Array( x, y, nodeId, elementId ), ... )
     * @param array anchorArrayships Array( id => Array( id, ... ), ... )
     * @throws Exception
     */
    public function handle( $floorId, array $anchors, array $relationships )
    {

        // Floor must exist
        $floor = $this->getDaoContainer()->getFloorBuildingDao()->get( $floorId );

        if ( !$floor )
        {
            throw new Exception( sprintf( "Floor \"%s\" does not exist", $floorId ) );
        }

        // Get Floor nodes
        $nodesList = $this->getDaoContainer()->getNodeNavigationBuildingDao()->getForeign(
                array ( $floor->getId() ) );

        // Nodes
        $nodesIds = array ();
        foreach ( $anchors as $anchorId => $anchorArray )
        {
            $coordinate = array ( "x" => intval( Core::arrayAt( $anchorArray, self::NODE_X, 0 ) ),
                    "y" => intval( Core::arrayAt( $anchorArray, self::NODE_Y, 0 ) ) );
            $nodeId = intval( Core::arrayAt( $anchorArray, self::NODE_ID ) );

            // Create Node
            $node = NodeNavigationBuildingFactoryModel::createNodeNavigationBuilding( $floor->getId(),
                    $coordinate, Core::arrayAt( $anchorArray, self::NODE_ELEMENT ) );

            // Delete Node
            if ( $nodeId && $nodesList->getId( $nodeId ) && Core::arrayAt( $anchorArray,
                    self::NODE_DELETED, false ) == "true" )
            {
                $this->getDaoContainer()->getNodeNavigationBuildingDao()->remove( $nodeId );
                $nodesList->removeId( $nodeId );
            }
            // Update Node
            else if ( $nodeId && $nodesList->getId( $nodeId ) )
            {
                $this->getDaoContainer()->getNodeNavigationBuildingDao()->edit( $nodeId, $node, $floor->getId() );
                $nodesIds[ $anchorId ] = $nodeId;
            }
            // New Node
            else
            {
                $nodeId = $this->getDaoContainer()->getNodeNavigationBuildingDao()->add( $node, $floor->getId() );

                $nodesList->add( $this->getDaoContainer()->getNodeNavigationBuildingDao()->get( $nodeId ) );
                $nodesIds[ $anchorId ] = $nodeId;
            }

        }

        // Edges
        $this->getDaoContainer()->getNodeNavigationBuildingDao()->removeEdges( $floorId );

        foreach ( $relationships as $nodeId => $edgesArray )
        {
            if ( $nodesList->getId( Core::arrayAt( $nodesIds, $nodeId ) ) )
            {
                foreach ( $edgesArray as $edgeNodeId )
                {
                    if ( $nodesList->getId( Core::arrayAt( $nodesIds, $edgeNodeId ) ) )
                    {
                        $this->getDaoContainer()->getNodeNavigationBuildingDao()->addEdge( $nodesIds[ $nodeId ],
                                $nodesIds[ $edgeNodeId ] );
                    }
                }
            }
        }
    }

    // /FUNCTIONS


}

?>