<?php

abstract class ImageView extends AbstractView
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see AbstractView::getController()
     * @return ImageController
     */
    public function getController()
    {
        return parent::getController();
    }

    /**
     * @return String Image path
     */
    protected abstract function getImagePath();

    /**
     * @see AbstractView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        parent::draw( $root );

        $createPng = ( bool ) false;
        $imagePath = $this->getImagePath();

        if ( !file_exists( $imagePath ) )
            throw new Exception( "Image does not exist" );
        DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "Image path", $imagePath ) );
        if ( $createPng )
        {
            $im = imagecreatefrompng( $imagePath );
            @header( 'Content-Type: image/png' );
            imagepng( $im ); //, basename( $imagePath, ".png" ) );
            imagedestroy( $im );
        }
        else
        {
            @header( 'Content-Type: image/png' );
            $img = file_get_contents( $imagePath );
            $root->content( $img );
        }

    }

    // /FUNCTIONS


}

?>