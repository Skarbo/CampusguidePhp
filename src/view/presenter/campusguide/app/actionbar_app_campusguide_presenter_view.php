<?php

class ActionbarAppCampusguidePresenterView extends PresenterView
{

    // VARIABLES


    /**
     * @var string
     */
    private $backReferer;
    /**
     * @var AbstractXhtml
     */
    private $icon;
    /**
     * @var AbstractXhtml
     */
    private $viewControl;
    /**
     * @var array
     */
    private $viewControlMenu = array ();
    /**
     * @var array
     */
    private $actionButtons = array ();
    /**
     * @var array
     */
    private $menu = array ();

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... SET


    /**
     * @param string $back Back referer, back icon is shown, clicking icon redirectrs to back refererer
     */
    public function setBackReferer( $back )
    {
        $this->backReferer = $back;
    }

    /**
     * @param AbstractXhtml $icon
     */
    public function setIcon( AbstractXhtml $icon )
    {
        $this->icon = $icon;
    }

    /**
     * @param AbstractXhtml $topLeft
     */
    public function setViewControl( AbstractXhtml $viewControl )
    {
        $this->viewControl = $viewControl;
    }

    // ... /SET


    // ... ADD


    /**
     * @param AbstractXhtml $button
     */
    public function addActionButton( AbstractXhtml $button )
    {
        $this->actionButtons[] = $button;
    }

    /**
     * Adds content to view control menu
     *
     * @param AbstractXhtml $content
     */
    public function addViewControlMenu( AbstractXhtml $menu )
    {
        $this->viewControlMenu[] = $menu;
    }

    /**
     * Add content to menu
     *
     * @param AbstractXhtml $icon
     * @param AbstractXhtml $menu
     */
    public function addMenu( AbstractXhtml $menu )
    {
        $this->menu[] = $menu;
    }

    // ... /ADD


    /**
     * Draw top of action bar
     *
     * @see PresenterView::draw()
     */
    public function draw( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->class_( "action_bar" )->id( "action_bar_top" );

        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        // LEFT
        $left = Xhtml::div()->class_( Resource::css()->getLeft() );

        // Icon
        $this->drawIcon( $left );

        // View control
        $this->drawViewControl( $left );

        $table->addContent( $left );

        // /LEFT


        // RIGHT
        $right = Xhtml::div()->class_( Resource::css()->getRight() );

        // Action buttons
        $this->drawActionButtons( $right );

        $table->addContent( $right );

        // /RIGHT


        $wrapper->addContent( $table );

        $root->addContent( $wrapper );

    }

    /**
     * Draw bottom of action bar
     *
     * @see PresenterView::draw()
     */
    public function drawBottom( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->class_( "action_bar" )->id( "action_bar_bottom" );

        // Action buttons
        $this->drawActionButtons( $wrapper );

        $root->addContent( $wrapper );
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawIcon( AbstractXhtml $root )
    {
        if ( !$this->icon )
            return;
        if ( $this->backReferer )
        {
            $wrapper = Xhtml::a()->href( $this->backReferer );
            $wrapper->addContent( Xhtml::div()->attr( "data-icon", "left" ) );
        }
        else
        {
            $wrapper = Xhtml::div();
        }

        $wrapper->class_( "action_icon" );
        $wrapper->addContent( $this->icon );

        $root->addContent( $wrapper );
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawViewControl( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->class_( "view_control" );

        if ( !empty( $this->viewControlMenu ) )
            $this->viewControl->attr( "data-icon", "rightdown" )->addClass( "more", Resource::css()->getHover() );

        $wrapper->addContent( $this->viewControl );

        $root->addContent( $wrapper );
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawActionButtons( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->class_( "action_buttons" );

        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        foreach ( $this->actionButtons as $actionButton )
        {
            $table->addContent(
                    Xhtml::div( $actionButton )->class_( Resource::css()->getCenter() )->style(
                            sprintf( "width: %s%%;", round( ( 1 / count( $this->actionButtons ) ) * 100, 2 ) ) ) );
        }

        $wrapper->addContent( $table );

        $root->addContent( $wrapper );
    }

    /**
     * @param AbstractXhtml $root
     */
    public function drawMenu( AbstractXhtml $root )
    {
        $wrapper = Xhtml::div()->id( "actionbar_menu_wrapper" )->attr( "data-fitparent", "#page_wrapper" )->class_( Resource::css()->getTable(), Resource::css()->getHide() );
        $div = Xhtml::div();
        $menuWrapper = Xhtml::div()->id( "actionbar_menu" );

        $table = Xhtml::div()->class_( Resource::css()->getTable() );

        foreach ( $this->menu as $menu )
        {
            $table->addContent(
                    AbstractXhtml::get_( $menu )->addClass( Resource::css()->getTableRow(), "menu_item",
                            Resource::css()->getHover(), Resource::css()->getHide() ) );
        }

        foreach ( $this->viewControlMenu as $menu )
        {
            $table->addContent(
                    AbstractXhtml::get_( $menu )->addClass( Resource::css()->getTableRow(), "menu_item",
                            Resource::css()->getHover(), Resource::css()->getHide(), "viewcontrol" ) );
        }

        $menuWrapper->addContent( $table );

        $div->addContent( Xhtml::div()->class_( "arrow" )->attr( "data-arrow", "up" ) );
        $div->addContent( $menuWrapper );
        $div->addContent( Xhtml::div()->class_( "arrow" )->attr( "data-arrow", "down" ) );

        $wrapper->addContent( $div );
        $root->addContent( $wrapper );
    }

    // /FUNCTIONS


}

?>