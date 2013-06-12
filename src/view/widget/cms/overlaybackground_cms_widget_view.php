<?php

class OverlaybackgroundCmsWidgetView extends AbstractWidgetView
{

    // VARIABLES


    private $backgroundImage;
    private $link;
    private $title;
    private $height;
    private $width;

    // /VARIABLES


    // CONSTRUCTOR


    /**
     * @param InterfaceView $view
     * @return OverlaybackgroundCmsWidgetView
     */
    public function __construct( InterfaceView $view )
    {
        parent::__construct( $view );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @param InterfaceView $view
     * @return OverlaybackgroundCmsWidgetView
     */
    public static function init( InterfaceView $view )
    {
        return parent::init( $view );
    }

    /**
     * @param String $backgroundImage
     * @return OverlaybackgroundCmsWidgetView
     */
    public function backgroundImage( $backgroundImage, $height, $width )
    {
        $this->backgroundImage = $backgroundImage;
        $this->height = $height;
        $this->width = $width;
        return $this;
    }

    /**
     * @param String $link
     * @return OverlaybackgroundCmsWidgetView
     */
    public function link( $link )
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @param String $title
     * @return OverlaybackgroundCmsWidgetView
     */
    public function title( $title )
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @see AbstractWidgetView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        /*
         * <div style="background-image: url(image.php?/building/645/map/150x75)" class="table facility_buildings_building_table">
         * <div title="Test Building">
         * <div title="Test Building" class="facility_buildings_building_content">
         * <a href="cms.php?/buildings/building/view/645&amp;mode=3">Test Building
         * </a></div></div></div>
         */

        $table = Xhtml::div()->style(
                sprintf( "background-image: url('%s'); height: %spx; width: %spx;", $this->backgroundImage, $this->height,
                        $this->width ) )->class_( Resource::css()->cms()->widget()->widget,
                Resource::css()->cms()->widget()->overlaybackground()->table );
        $cell = Xhtml::div()->title( $this->title );
        $wrapper = Xhtml::div()->title( $this->title )->class_(
                Resource::css()->cms()->widget()->overlaybackground()->wrapper )->style(
                sprintf( "width: %spx;", $this->width ) );
        $wrapper->addContent( Xhtml::a( $this->title, $this->link ) );
        $cell->addContent( $wrapper );
        $table->addContent( $cell );

        $root->addContent( $table );

    }

    // /FUNCTIONS


}

?>