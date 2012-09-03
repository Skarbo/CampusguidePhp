<?php

class FloorBuildingHandler extends Handler
{

    // VARIABLES


    /**
     * @var FloorBuildingDao
     */
    var $floorBuildingDao;
    /**
     * @var FloorBuildingValidator
     */
    var $floorBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( FloorBuildingDao $floorBuildingDao, FloorBuildingValidator $floorBuildingValidator )
    {
        $this->floorBuildingDao = $floorBuildingDao;
        $this->floorBuildingValidator = $floorBuildingValidator;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return FloorBuildingDao
     */
    public function getFloorBuildingDao()
    {
        return $this->floorBuildingDao;
    }

    /**
     * @param FloorBuildingDao $floorBuildingDao
     */
    public function setFloorBuildingDao( FloorBuildingDao $floorBuildingDao )
    {
        $this->floorBuildingDao = $floorBuildingDao;
    }

    /**
     * @return FloorBuildingValidator
     */
    public function getFloorBuildingValidator()
    {
        return $this->floorBuildingValidator;
    }

    /**
     * @param FloorBuildingValidator $floorBuildingValidator
     */
    public function setFloorBuildingValidator( FloorBuildingValidator $floorBuildingValidator )
    {
        $this->floorBuildingValidator = $floorBuildingValidator;
    }

    // ... /GETTERS/SETTERS


    // ... HANDLE


    /**
     * @param int $buildingId
     * @param FloorBuildingModel $floor
     * @return FloorBuildingModel Added floor
     * @throws ValidatorException
     */
    public function handleAddFloor( $buildingId, FloorBuildingModel $floor )
    {

        // Get Building Floors
        $floors = $this->getFloorBuildingDao()->getForeign( array ( $buildingId ) );

        // Get last Building Floor
        $floorLast = 0;
        for ( $floors->rewind(); $floors->valid(); $floors->next() )
        {
            $floorTemp = $floors->current();
            $floorLast = $floorTemp->getOrder() > $floorLast ? $floorTemp->getOrder() + 1 : $floorLast;
        }

        // Set floor
        $floor->setOrder( $floorLast );

        // Set building id
        $floor->setBuildingId( $buildingId );

        // Validate Floor
        $this->getFloorBuildingValidator()->doValidate( $floor, "Floor is not validated" );

        // Add Floor
        $floorId = $this->getFloorBuildingDao()->add( $floor, $buildingId );

        // Get Floor
        $floorAdded = $this->getFloorBuildingDao()->get( $floorId );

        // Set main Floor
        if ( $floor->getMain() )
        {
            $this->getFloorBuildingDao()->setMainFloor( $buildingId, $floorAdded->getId() );
        }

        // Return Floor
        return $floorAdded;

    }

    /**
     * @param int $buildingId
     * @param FloorBuildingListModel $floors
     * @return FloorBuildingListModel
     * @throws ValidatorException
     */
    public function handleEditFloors( $buildingId, FloorBuildingListModel $floors )
    {

        // Get Building Floors
        $floorsAll = $this->getFloorBuildingDao()->getForeign( array ( $buildingId ) );

        // Foreach floors
        $floorOrder = 0;
        $floorMain = null;
        for ( $floors->rewind(); $floors->valid(); $floors->next() )
        {
            $floor = $floors->current();

            // Set floor main
            $floorMain = $floor->getMain() ? $floor->getId() : $floorMain;

            // Set Floor order
            $floor->setOrder( $floorOrder );

            // Sett Floor Building
            $floor->setBuildingId( $buildingId );

            // Validate Floor
            $this->getFloorBuildingValidator()->doValidate( $floor,
                    sprintf( "Floor (#%d) is not validated", $floor->getId() ) );

            // Edit Floor
            $this->getFloorBuildingDao()->edit( $floor->getId(), $floor, $buildingId );

            // Increase floor order
            $floorOrder++;
        }

        // Set main floor
        $this->getFloorBuildingDao()->setMainFloor( $buildingId, $floorMain );

        // Get updated Floors
        $floorsUpdated = $this->getFloorBuildingDao()->getForeign( array ( $buildingId ) );

        // Return updated Floors
        return $floorsUpdated;

    }

    // ... /HANDLE


    // /FUNCTIONS


}

?>