<?php

class ControllerMenuCmsCampusguidePresenterView extends PresenterView
{

    // VARIABLES


    public static $ID_MENU_WRAPPER = "controller_menu_wrapper";

    /**
     * @var array
     */
    private $items = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @param integer $index
     * @return ItemMenuCmsCampusguidePresenterView
     */
    private function getItem( $index )
    {
        return Core::arrayAt( $this->items, $index, null );
    }

    // ... /GET


    // ... ADD


    /**
     * @param ItemMenuCmsCampusguidePresenterView $item
     */
    public function addItem( $title, $link, $highlighted = false )
    {
        $this->items[] = new ItemControllerMenuCmsCampusguidePresenterView( $title, $link, $highlighted );
    }

    // ... /ADD


    // ... /CREATE


    /**
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create menu wrapper
        $menuWrapper = Xhtml::div()->id( self::$ID_MENU_WRAPPER );

        // Create menu
        $menu = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->menu()->getMenu() );

        // Foreach items
        foreach ( $this->items as $item )
        {
            // Draw item
            $this->drawItem( $item, $menu );
        }

        // Add menu to menu wrapper
        $menuWrapper->addContent( $menu );

        // Add menu wrapper to root
        $root->addContent( $menuWrapper );

    }

    /**
     * @param ItemControllerMenuCmsCampusguidePresenterView $item
     * @param AbstractXhtml $root
     */
    private function drawItem( ItemControllerMenuCmsCampusguidePresenterView $item, AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->menu()->getItem() );

        // Create link
        $link = Xhtml::a( $item->getTitle() )->href( $item->getLink() );

        // Highlighted
        if ( $item->isHighlighted() )
        {
            $wrapper->addClass( Resource::css()->campusguide()->cms()->menu()->getItemHighlighted() );
        }

        // Add link to wrapper
        $wrapper->addContent( $link );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

class ItemControllerMenuCmsCampusguidePresenterView extends ClassCore
{

    // VARIABLES


    /**
     * @var title
     */
    private $title;
    /**
     * @var string
     */
    private $link;
    /**
     * @var boolean
     */
    private $highlighted;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $title, $link, $highlighted = false )
    {
        $this->setTitle( $title );
        $this->setLink( $link );
        $this->setHighlighted( $highlighted );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle( $title )
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink( $link )
    {
        $this->link = $link;
    }

    /**
     * @return boolean
     */
    public function isHighlighted()
    {
        return $this->highlighted;
    }

    /**
     * @param boolean $highlighted
     */
    public function setHighlighted( $highlighted )
    {
        $this->highlighted = $highlighted;
    }

    /**
     * @param ItemMenuCmsCampusguidePresenterView $get
     * @return ItemMenuCmsCampusguidePresenterView
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // /FUNCTIONS


}

?>