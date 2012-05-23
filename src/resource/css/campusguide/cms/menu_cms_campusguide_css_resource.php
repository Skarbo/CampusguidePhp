<?php

class MenuCmsCampusguideCssResource extends ClassCore
{

    // VARIABLES


    private $menu = "menu";

    private $align = "align";
    private $alignLeft = "left";
    private $alignMidle = "midle";
    private $alignRight = "right";

    private $item = "item";
    private $itemHighlighted = "highligthed";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getMenu()
    {
        return $this->menu;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function getItemHighlighted()
    {
        return $this->itemHighlighted;
    }

    public function getAlignLeft()
    {
        return $this->alignLeft;
    }

    public function getAlignMidle()
    {
        return $this->alignMidle;
    }

    public function getAlignRight()
    {
        return $this->alignRight;
    }
	public function getAlign()
    {
        return $this->align;
    }


}

?>