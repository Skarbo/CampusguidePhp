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
     * @see View::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        // Set Image PNG as Content type
        @header( 'Content-Type: image/png' );

        // Get image path
        $imagePath = $this->getController()->getImage();

        // Image must exist
        if ( !file_exists( $imagePath ) )
        {
            $imagePath = Resource::image()->campusguide()->building()->getDefaultBuildingOverview();
        }

        // Get image contents
        $img = file_get_contents( $imagePath );

        $root->content( $img );

    }

    // /FUNCTIONS


}

?>