<?php

class BuildingCmsImageView extends ImageView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see AbstractView::getController()
     * @return BuildingCmsImageController
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

    // ... /GET


    /**
     * @see ImageView::getImagePath()
     */
    protected function getImagePath()
    {
        return $this->getController()->getImage();
    }

    // /FUNCTIONS


}

?>