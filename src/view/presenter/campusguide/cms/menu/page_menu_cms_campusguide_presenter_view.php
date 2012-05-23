<?php

class PageMenuCmsCampusguidePresenterView extends PresenterView
{

    // VARIABLES


    public static $ID_MENU_WRAPPER = "page_menu_wrapper";

    /**
     * @var array
     */
    private $items = array ();
    /**
     * @var DivXhtml
     */
    private $left;
    /**
     * @var DivXhtml
     */
    private $midle;
    /**
     * @var DivXhtml
     */
    private $right;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( MainView $view )
    {
        parent::__construct( $view );
        $this->left = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->menu()->getAlign() );
        $this->midle = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->menu()->getAlign() );
        $this->right = Xhtml::div()->class_( Resource::css()->campusguide()->cms()->menu()->getAlign() );
    }

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
    public function addItem( $title, $link, $highlighted = false, $align = ItemPageMenuCmsCampusguidePresenterView::ALIGN_LEFT )
    {
        $this->items[] = new ItemPageMenuCmsCampusguidePresenterView( $title, $link, $highlighted, $align );
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
            $this->drawItem( $item );
        }

        // Add left, midle, and right to menu
        $menu->addContent(
                Xhtml::div( $this->left )->class_( Resource::css()->campusguide()->cms()->menu()->getAlignLeft() ) );
        $menu->addContent(
                Xhtml::div( $this->midle )->class_( Resource::css()->campusguide()->cms()->menu()->getAlignMidle() ) );
        $menu->addContent(
                Xhtml::div( $this->right )->class_( Resource::css()->campusguide()->cms()->menu()->getAlignRight() ) );

        // Add menu to menu wrapper
        $menuWrapper->addContent( $menu );

        // Add menu wrapper to root
        $root->addContent( $menuWrapper );

    }

    private function drawItem( ItemPageMenuCmsCampusguidePresenterView $item )
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

        // Align
        switch ( $item->getAlign() )
        {
            case ItemPageMenuCmsCampusguidePresenterView::ALIGN_MIDLE :
                $this->midle->addContent( $wrapper );
                break;

            case ItemPageMenuCmsCampusguidePresenterView::ALIGN_RIGHT :
                $this->right->addContent( $wrapper );
                break;

            default :
                $this->left->addContent( $wrapper );
                break;
        }

    }

    // /FUNCTIONS


}

class ItemPageMenuCmsCampusguidePresenterView extends ClassCore
{

    // VARIABLES


    const ALIGN_LEFT = "left";
    const ALIGN_MIDLE = "midle";
    const ALIGN_RIGHT = "right";

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
    /**
     * @var string
     */
    private $align;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $title, $link, $highlighted = false, $align = self::ALIGN_LEFT )
    {
        $this->setTitle( $title );
        $this->setLink( $link );
        $this->setHighlighted( $highlighted );
        $this->setAlign( $align );
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
     * @return string
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * @param string $align
     */
    public function setAlign( $align )
    {
        $this->align = $align;
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