<?php

class BuildingBuildingsCmsCssResource extends ClassCore
{

    private static $VIEW;

    /**
     * @return ViewBuildingBuildingsCmsCssResource
     */
    public function view()
    {
        self::$VIEW = self::$VIEW ? self::$VIEW : new ViewBuildingBuildingsCmsCssResource();
        return self::$VIEW;
    }

}

?>