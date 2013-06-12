<?php

class NavigateHandler extends Handler
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param ElementBuildingModel $element
     * @param array $position Array( x => x, y => y )
     * @param FloorBuildingModel $floor Floor position is at
     * @param NodeNavigationBuildingListModel $navigationNodes Navigation nodes for Building
     * @return Array Array( Node id, ... )
     */
    public function handle( ElementBuildingModel $element, array $position, FloorBuildingModel $floor, NodeNavigationBuildingListModel $navigationNodes )
    {
        if ( $navigationNodes->isEmpty() )
            return array ();

        $isOnSameFloor = $element->getFloorId() == $floor->getId();

        DebugHandler::doDebug( DebugHandler::LEVEL_LOW,
                new DebugException( "NavigateHandler.handle", "Element", $element->getId(), "Position", $position,
                        $navigationNodes->size() ) );

        $directedGraph = array ();
        $i = 0;
        $minDistance = $this->getDistance( $position, $navigationNodes->get( 0 )->getCoordinate() );
        $minNode = $navigationNodes->get( 0 )->getId();
        $elementNode = null;
        for ( $navigationNodes->rewind(); $navigationNodes->valid(); $navigationNodes->next() )
        {
            $navigationNode = $navigationNodes->current();
            foreach ( $navigationNode->getEdges() as $nodeId )
            {
                $index = $navigationNodes->getIndex( $nodeId );
                if ( $index > -1 )
                    $directedGraph[ $i ][] = $index;
            }
            $distance = $this->getDistance( $position, $navigationNode->getCoordinate() );
            if ( $distance < $minDistance )
            {
                $minDistance = $distance;
                $minNode = $navigationNode->getId();
            }
            if ( $navigationNode->getElementId() == $element->getId() )
                $elementNode = $navigationNode->getId();
            $i++;
        }

        $start = $navigationNodes->getIndex( $minNode );
        $end = $navigationNodes->getIndex( $elementNode );

        $undirectedGraph = $this->directed2Undirected( $directedGraph );
        $weightGraph = $this->undirectedToWeight( $undirectedGraph, 1 );
        $path = $this->dijksrtas( $weightGraph, $navigationNodes->size(), $start, $end );

        if ( !empty( $path ) && isset( $path[ $end ] ) )
        {
            $pathNodes = array ();
            foreach ( $path[ $end ] as $i )
            {
                $node = $navigationNodes->get( $i );
                if ( $node )
                    $pathNodes[] = $node->getId();
            }
            return $pathNodes;
        }
        return null;
    }

    /**
     * @param array $point
     * @param NodeNavigationBuildingListModel $navigationNodes
     * @return NodeNavigationBuildingModel
     */
    public function getClosestNodeFromPoint( array $point, NodeNavigationBuildingListModel $navigationNodes )
    {
        if ( $navigationNodes->isEmpty() )
            return null;

        $minDistance = $this->getDistance( $point, $navigationNodes->get( 0 )->getCoordinate() );
        $minNode = $navigationNodes->get( 0 );

        for ( $navigationNodes->rewind(); $navigationNodes->valid(); $navigationNodes->next() )
        {
            $navigationNode = $navigationNodes->current();
            $distance = $this->getDistance( $point, $navigationNode->getCoordinate() );
            if ( $distance < $minDistance )
            {
                $minDistance = $distance;
                $minNode = $navigationNode;
            }
        }

        return $minNode;
    }

    /**
     * @param array $left
     * @param array $right
     * @return number Distance between left and right
     */
    public function getDistance( array $left, array $right )
    {
        $leftCalc = abs( Core::arrayAt( $left, "x" ) - Core::arrayAt( $right, "x" ) );
        $rightCalc = abs( Core::arrayAt( $left, "y" ) - Core::arrayAt( $right, "y" ) );
        return $leftCalc + $rightCalc;
    }

    private function directed2Undirected( $data )
    {
        foreach ( $data as $key => $values )
        {
            foreach ( $values as $value )
            {
                $data[ $value ][] = $key;
            }
        }

        return $data;
    }

    private function undirectedToWeight( $data, $weight )
    {
        $weightGraph = array ();
        foreach ( $data as $key => $values )
        {
            foreach ( $values as $value )
            {
                $weightGraph[] = array ( $key, $value, $weight );
            }
        }

        return $weightGraph;
    }

    private function bfsShortestPath( array $g, $s, $f )
    {
        $explored = array ();
        $distance = array ();
        foreach ( $g as $k => $v )
            $distance[ $k ] = $k == $s ? 0 : -1;
        $q = array ( $s );
        $explored[] = $s;
        while ( !empty( $q ) )
        {
            $v = array_shift( $q );
            foreach ( $g[ $v ] as $u )
            {
                if ( $u == $f )
                    echo "JADA!";
                if ( !in_array( $u, $explored ) )
                {
                    $distance[ $u ] = $distance[ $v ] + 1;
                    $explored[] = $u;
                    $q[] = $u;
                }
            }
        }
        return array ( $explored, $distance );
    }

    // from http://joshosopher.tumblr.com/post/3195564776/dijkstras-algorithm
    private function dijkstra( array $g, $start, $end = null )
    {
        $d = array ();
        $p = array ();
        $q = array ( 0 => $start );

        foreach ( $q as $v )
        {
            $d[ $v ] = $q[ $v ];
            if ( $v == $end )
                break;

            foreach ( $g[ $v ] as $w )
            {
                $vw = $d[ $v ] + $g[ $v ][ $w ];

                if ( in_array( $w, $d ) )
                {
                    if ( $vw < $d[ $w ] )
                        throw new Exception( 'Dijkstra: found better path to already-final vertex' );
                }
                elseif ( $vw < $q[ $w ] )
                {
                    $q[ $w ] = $vw;
                    $p[ $w ] = $v;
                }
            }

            return array ( $d, $p );
        }
    }

    private function shortestPath( array $g, $start, $end )
    {
        list ( $d, $p ) = $this->dijkstra( $g, $start, $end );
        $path = array ();
        //         while ( true )
        //         {
        //             $path[] = $end;
        //             if ( $end == $start )
        //                 break;
        //             $end = $p[ $end ];
        //         }


        array_reverse( $path );

        return $path;
    }

    private function dijksrtas( $points, $matrixWidth, $start, $find )
    {
        // I is the infinite distance.
        define( 'I', 1000 );

        //         // Size of the matrix
        //         $matrixWidth = 4;


        //         // $points is an array in the following format: (router1,router2,distance-between-them)
        //         $points = array ( array ( 0, 1, 4 ), array ( 0, 2, I ), array ( 1, 2, 5 ), array ( 1, 3, 5 ),
        //                 array ( 2, 3, 5 ), array ( 3, 4, 5 ), array ( 4, 5, 5 ), array ( 4, 5, 5 ), array ( 2, 10, 30 ),
        //                 array ( 2, 11, 40 ), array ( 5, 19, 20 ), array ( 10, 11, 20 ), array ( 12, 13, 20 ) );
        //         $points = array ( array ( 0, 11, 1 ), array ( 11, 0, 1 ), array ( 11, 22, 1 ), array ( 22, 11, 1 ),
        //                 array ( 22, 33, 1 ), array ( 33, 22, 1 ) );


        $ourMap = array ();

        // Read in the points and push them into the map


        for ( $i = 0, $m = count( $points ); $i < $m; $i++ )
        {
            $x = $points[ $i ][ 0 ];
            $y = $points[ $i ][ 1 ];
            $c = $points[ $i ][ 2 ];
            $ourMap[ $x ][ $y ] = $c;
            $ourMap[ $y ][ $x ] = $c;
        }

        // ensure that the distance from a node to itself is always zero
        // Purists may want to edit this bit out.


        for ( $i = 0; $i < $matrixWidth; $i++ )
        {
            for ( $k = 0; $k < $matrixWidth; $k++ )
            {
                if ( $i == $k )
                    $ourMap[ $i ][ $k ] = 0;
            }
        }

        // initialize the algorithm class
        $dijkstra = new Dijkstra( $ourMap, I, $matrixWidth );

        // $dijkstra->findShortestPath(0,13); to find only path from field 0 to field 13...va


        $dijkstra->findShortestPath( $start, $find );

        // Display the results


        //         echo '<pre>';
        //         echo "the map looks like:\n\n";
        //         echo $dijkstra->printMap( $ourMap );
        //         echo "\n\nthe shortest paths from point 0:\n";
        return $dijkstra->getResults( $find );
        //         echo '</pre>';
    }

    // /FUNCTIONS


}

class Dijkstra
{

    var $visited = array ();
    var $distance = array ();
    var $previousNode = array ();
    var $startnode = null;
    var $map = array ();
    var $infiniteDistance = 0;
    var $numberOfNodes = 0;
    var $bestPath = 0;
    var $matrixWidth = 0;

    function Dijkstra( &$ourMap, $infiniteDistance )
    {
        $this->infiniteDistance = $infiniteDistance;
        $this->map = &$ourMap;
        $this->numberOfNodes = count( $ourMap );
        $this->bestPath = 0;
    }

    function findShortestPath( $start, $to = null )
    {
        $this->startnode = $start;
        for ( $i = 0; $i < $this->numberOfNodes; $i++ )
        {
            if ( $i == $this->startnode )
            {
                $this->visited[ $i ] = true;
                $this->distance[ $i ] = 0;
            }
            else
            {
                $this->visited[ $i ] = false;
                $this->distance[ $i ] = isset( $this->map[ $this->startnode ][ $i ] ) ? $this->map[ $this->startnode ][ $i ] : $this->infiniteDistance;
            }
            $this->previousNode[ $i ] = $this->startnode;
        }

        $maxTries = $this->numberOfNodes;
        $tries = 0;
        while ( in_array( false, $this->visited, true ) && $tries <= $maxTries )
        {
            $this->bestPath = $this->findBestPath( $this->distance, array_keys( $this->visited, false, true ) );
            if ( $to !== null && $this->bestPath === $to )
            {
                break;
            }
            $this->updateDistanceAndPrevious( $this->bestPath );
            $this->visited[ $this->bestPath ] = true;
            $tries++;
        }
    }

    function findBestPath( $ourDistance, $ourNodesLeft )
    {
        $bestPath = $this->infiniteDistance;
        $bestNode = 0;
        for ( $i = 0, $m = count( $ourNodesLeft ); $i < $m; $i++ )
        {
            if ( $ourDistance[ $ourNodesLeft[ $i ] ] < $bestPath )
            {
                $bestPath = $ourDistance[ $ourNodesLeft[ $i ] ];
                $bestNode = $ourNodesLeft[ $i ];
            }
        }
        return $bestNode;
    }

    function updateDistanceAndPrevious( $obp )
    {
        for ( $i = 0; $i < $this->numberOfNodes; $i++ )
        {
            if ( ( isset( $this->map[ $obp ][ $i ] ) ) && ( !( $this->map[ $obp ][ $i ] == $this->infiniteDistance ) ||
                     ( $this->map[ $obp ][ $i ] == 0 ) ) &&
                     ( ( $this->distance[ $obp ] + $this->map[ $obp ][ $i ] ) < $this->distance[ $i ] ) )
                    {
                        $this->distance[ $i ] = $this->distance[ $obp ] + $this->map[ $obp ][ $i ];
                $this->previousNode[ $i ] = $obp;
            }
        }
    }

    function printMap( &$map )
    {
        $placeholder = ' %' . strlen( $this->infiniteDistance ) . 'd';
        $foo = '';
        for ( $i = 0, $im = count( $map ); $i < $im; $i++ )
        {
            for ( $k = 0, $m = $im; $k < $m; $k++ )
            {
                $foo .= sprintf( $placeholder, isset( $map[ $i ][ $k ] ) ? $map[ $i ][ $k ] : $this->infiniteDistance );
            }
            $foo .= "\n";
        }
        return $foo;
    }

    function getResults( $to = null )
    {
        $ourShortestPath = array ();
        $foo = '';
        for ( $i = 0; $i < $this->numberOfNodes; $i++ )
        {
            if ( $to !== null && $to !== $i )
            {
                continue;
            }
            $ourShortestPath[ $i ] = array ();
            $endNode = null;
            $currNode = $i;
            $ourShortestPath[ $i ][] = $i;
            while ( $endNode === null || $endNode != $this->startnode )
            {
                $ourShortestPath[ $i ][] = $this->previousNode[ $currNode ];
                $endNode = $this->previousNode[ $currNode ];
                $currNode = $this->previousNode[ $currNode ];
            }
            $ourShortestPath[ $i ] = array_reverse( $ourShortestPath[ $i ] );
            if ( $to === null || $to === $i )
            {
                if ( $this->distance[ $i ] >= $this->infiniteDistance )
                {
                    $foo .= sprintf( "no route from %d to %d. \n", $this->startnode, $i );
                }
                else
                {
                    $foo .= sprintf( '%d => %d = %d [%d]: (%s).' . "\n", $this->startnode, $i, $this->distance[ $i ],
                            count( $ourShortestPath[ $i ] ), implode( '-', $ourShortestPath[ $i ] ) );
                }
                $foo .= str_repeat( '-', 20 ) . "\n";
                if ( $to === $i )
                {
                    break;
                }
            }
        }
        //         var_dump($ourShortestPath);
        //         var_dump($ourShortestPath[count($ourShortestPath)-1]);
        //         echo $foo . "<br />";
        return $ourShortestPath;
    }
} // end class


?>