<?php

class BuildingDefaultLocale extends Locale
{

    // VARIABLES


    private static $ELEMENT;

    public $building = "Building";
    public $buildings = "Buildings";
    public $floor = "Floor";
    public $floors = "Floors";

    protected $deletingBuilding = "Deleting %d %s";
    protected $deletingBuildingSure = "Are you sure you want to delete %d %s?";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return ElementBuildingDefaultLocale
     */
    public function element()
    {
        self::$ELEMENT = self::$ELEMENT ? self::$ELEMENT : new ElementBuildingDefaultLocale();
        return self::$ELEMENT;
    }

    // /FUNCTIONS


    public function getFloors( $count )
    {
        return sprintf( "%d %s", $count, Locale::instance()->quantity( $count, $this->floor, $this->floors ) );
    }

    public function getDeletingBuilding( $buildingsSize )
    {
        return ucwords(
                sprintf( $this->deletingBuilding, $buildingsSize,
                        Locale::instance()->quantity( $buildingsSize, $this->building, $this->buildings ) ) );
    }

    public function getDeletingBuildingSure( $buildingsSize )
    {
        return sprintf( $this->deletingBuildingSure, $buildingsSize,
                Locale::instance()->quantity( $buildingsSize, $this->building, $this->buildings ) );
    }

}

?>