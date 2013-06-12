<?php

class ControllerMenuCmsPresenterView extends PresenterView
{

    // VARIABLES


    public static $ID_MENU_WRAPPER = "controller_menu_wrapper";

    /**
     * @var array
     */
    private $items = array ();
    /**
     * @var array
     */
    private $subitems = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @param integer $index
     * @return ItemMenuCmsPresenterView
     */
    private function getItem( $index )
    {
        return Core::arrayAt( $this->items, $index, null );
    }

    // ... /GET


    // ... ADD


    /**
     * @return ItemMenuCmsPresenterView
     */
    public function addItem( $title, $link, $highlighted = false )
    {
        $item = new ItemControllerMenuCmsPresenterView( $title, $link, $highlighted );
        $this->items[] = $item;
        return $item;
    }

    // ... /ADD


    // ... /CREATE


    /**
     * @see AbstractPresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {

        // Create menu wrapper
        $menuWrapper = Xhtml::div()->id( self::$ID_MENU_WRAPPER );

        // Create menu
        $menu = Xhtml::div()->class_( Resource::css()->cms()->menu()->getMenu() );

//         $menuItemHighlighted = null;

        // Foreach items
        foreach ( $this->items as $item )
        {
            // Draw item
            $this->drawItem( $item, $menu );

//             if ( ItemControllerMenuCmsPresenterView::get_( $item )->isHighlighted() )
//                 $menuItemHighlighted = $item;
        }

//         // Menu sub menu
//         $menuSub = Xhtml::div()->class_( Resource::css()->cms()->menu()->getMenuSub() );
//         if ( $menuItemHighlighted )
//         {
//             $menuItemHighlighted = ItemControllerMenuCmsPresenterView::get_( $menuItemHighlighted );

//             // Foreach sub items
//             foreach ( $menuItemHighlighted->getSubItems() as $item )
//             {
//                 $this->drawItem( $item, $menuSub );

//                 $menuSub->addClass( "hassub" );
//             }

//         }

//         $menuSub->addContent(Xhtml::div(Xhtml::$NBSP)->class_("spacer"));

        // Add menu to menu wrapper
        $menuWrapper->addContent( $menu );

//         // Add sub menu to menu wrapper
//         $menuWrapper->addContent( $menuSub );

        // Add menu wrapper to root
        $root->addContent( $menuWrapper );

    }

    /**
     * @param ItemControllerMenuCmsPresenterView $item
     * @param AbstractXhtml $root
     */
    private function drawItem( ItemControllerMenuCmsPresenterView $item, AbstractXhtml $root )
    {

        // Create wrapper
        $wrapper = Xhtml::div()->class_( Resource::css()->cms()->menu()->getItem() );

        // Create link
        $link = Xhtml::a( $item->getTitle() )->href( $item->getLink() );

        // Highlighted
        if ( $item->isHighlighted() )
        {
            $wrapper->addClass( Resource::css()->cms()->menu()->getItemHighlighted() );
        }

        // Add link to wrapper
        $wrapper->addContent( $link );

        // Add wrapper to root
        $root->addContent( $wrapper );

    }

    // /FUNCTIONS


}

class ItemControllerMenuCmsPresenterView extends ClassCore
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
    /**
     * @var array
     */
    private $subItems = array ();

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


    public function addSub( $title, $link, $highlighted = false )
    {
        $this->subItems[] = new ItemControllerMenuCmsPresenterView( $title, $link, $highlighted );
    }

    /**
     * @return array
     */
    public function getSubItems()
    {
        return $this->subItems;
    }

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
     * @param ItemControllerMenuCmsPresenterView $get
     * @return ItemControllerMenuCmsPresenterView
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // /FUNCTIONS


}

?>