<?php

class FacilityCmsCampusguideImageView extends ImageView
{

    // VARIABLES


    private static $MAP_FACILITY = "http://maps.googleapis.com/maps/api/staticmap?size=200x100&markers=size:small|color:red|%s&sensor=false";

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @see View::getController()
     * @return FacilityCmsCampusguideImageController
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
        @header( "Content-Type: image/png" );

        // Get image path
        $imagePath = $this->getController()->getImage();

        // Image must exist
        if ( !file_exists( $imagePath ) )
        {
            $imagePath = Resource::image()->campusguide()->facility()->getDefaultFacilityMap();
        }

        // Get image contents
        $img = file_get_contents( $imagePath );

        $root->content( $img );

    }

    // /FUNCTIONS


}

?>