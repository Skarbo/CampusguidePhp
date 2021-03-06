<?php

class FacilityCmsImageView extends ImageView
{

    // VARIABLES


    private static $MAP_FACILITY = "http://maps.googleapis.com/maps/api/staticmap?size=200x100&markers=size:small|color:red|%s&sensor=false";

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractView::getController()
     * @return FacilityCmsImageController
     */
    public function getController()
    {
        return parent::getController();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractView::getLastModified()
     */
    protected function getLastModified()
    {
        return max( parent::getLastModified(), filemtime( __FILE__ ), $this->getController()->getLastModified() );
    }

    /**
     * @see ImageView::getImagePath()
     */
    protected function getImagePath()
    {
        return $this->getController()->getImage();
    }

    // ... /GET


    // /FUNCTIONS


}

?>