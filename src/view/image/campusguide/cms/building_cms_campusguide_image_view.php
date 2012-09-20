<?php

class BuildingCmsCampusguideImageView extends ImageView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see View::getController()
     * @return BuildingCmsCampusguideImageController
     */
    public function getController()
    {
        return parent::getController();
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see View::getLastModified()
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