<?php

class FloorBuildingImageResource extends ClassCore
{

    private $floorsSvg = "floors";

    public function getFloors( $stroke = null, $fill = null )
    {
        return IconImageResource::getSvg( $this->floorsSvg, $stroke, $fill );
    }

}

?>