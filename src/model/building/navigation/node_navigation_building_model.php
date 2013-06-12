<?php

class NodeNavigationBuildingModel extends Model implements StandardModel
{

    // VARIABLES

    public static $EDGES_SPLIT = ",";

    const ID = "id";
    const FLOORID = "floorId";
    const ELEMENTID = "elementId";
    const COORDINATE = "coordinate";
    const EDGES = "edges";
    const UPDATED = "updated";
    const REGISTERED = "registered";

    public $id;
    public $floorId;
    public $elementId;
    public $coordinate;
    private $updated;
    private $registered;

    /**
     * @var Array
     */
    public $edges = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return $this->getFloorId();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getFloorId()
    {
        return $this->floorId;
    }

    public function setFloorId( $floorId )
    {
        $this->floorId = $floorId;
    }

    public function getElementId()
    {
        return $this->elementId;
    }

    public function setElementId( $elementId )
    {
        $this->elementId = $elementId;
    }

    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function setCoordinate( $coordinate )
    {
        $this->coordinate = $coordinate;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setUpdated( $updated )
    {
        $this->updated = $updated;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function setRegistered( $registered )
    {
        $this->registered = $registered;
    }

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getUpdated(), $this->getRegistered() );
    }

    // ... STATIC


    /**
     * @param NodeNavigationBuildingModel $get
     * @return NodeNavigationBuildingModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    /**
     * @return Array
     */
    public function getEdges()
    {
        return $this->edges;
    }

    public function setEdges( array $edges )
    {
        $this->edges = $edges;
    }

    // /FUNCTIONS


}

?>