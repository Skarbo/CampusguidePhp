<?php

class SelectsliderCmsPresenterView extends AbstractPresenterView
{

    // VARIABLES


    /**
     * @var Closure
     */
    private $contentFunction;
    private $id;
    private $templateUrl;
    private $templateImage;
    private $value;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( AbstractMainView $view, $id, $templateUrl, $templateImage, $value = 0 )
    {
        parent::__construct( $view );
        $this->id = $id;
        $this->templateUrl = $templateUrl;
        $this->templateImage = $templateImage;
        $this->value = $value;
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... SET


    /**
     * @param Closure $contentFunction Function( AbstractXhtml $root, SliderCmsPresenterView $slider )
     */
    public function setContentFunction( Closure $contentFunction )
    {
        $this->contentFunction = $contentFunction;
    }

    public function setTemplateUrl( $url )
    {
        $this->templateUrl = $url;
    }

    // ... /SET


    public function createContent( $id, $bgimage, $title, $url )
    {
        $wrapper = Xhtml::div()->class_( "selectslider_content_wrapper" )->attr( "data-id", $id );

        $div = Xhtml::div()->style(
                $bgimage ? sprintf( "background: url('%s') no-repeat scroll 0 0 #CCC;", $bgimage ) : "" )->class_(
                "image", Resource::css()->getTable() )->title( $title );

        $link = Xhtml::a( $title )->href( $url )->target( AnchorXhtml::$TARGET_BLANK );
        $div->addContent( Xhtml::div( Xhtml::div( $link ) )->class_( "name" ) );

        $wrapper->addContent( $div );

        return Xhtml::div( $wrapper );
    }

    public function draw( AbstractXhtml $root )
    {

        // Create table
        $table = Xhtml::div()->class_( Resource::css()->getTable(), "selectslider" )->id( $this->id );

        // Create selected
        $selected = Xhtml::div()->class_( "selectslider_selected", Resource::css()->getHide());

        // Create none
        $none = Xhtml::div(
                Xhtml::div()->addContent(
                        Xhtml::div( Xhtml::div( Xhtml::div( "?" ) )->class_( Resource::css()->getTableRow() ) )->addContent(
                                Xhtml::div( Xhtml::div( "None selected" ) )->class_( "name" ) )->class_( "image",
                                "table" ) )->class_( "selectslider_content_wrapper" ) )->class_(
                "selectslider_selected_none" );

        // ALL


        // Create all
        $all = Xhtml::div();

        // Create table
        $sliderTable = Xhtml::div()->class_( "selectslider_content", Resource::css()->getTable() )->attr(
                "data-width-parent", ".selectslider_contents_wrapper" );

        // Draw contents
        $this->drawContents( $sliderTable );

        $sliderTable->addContent( Xhtml::div()->class_( Resource::css()->getTableCellFill() ) );

        $all->addContent( Xhtml::div( $sliderTable )->class_( "selectslider_contents_wrapper" ) );

        // /FACILITIES ALL


        // TEMPLATE


        $template = Xhtml::div( $this->createContent( "id", $this->templateImage, "Template", $this->templateUrl ) )->class_(
                "selectslider_template" );

        // /TEMPLATE


        $table->addContent( $selected );
        $table->addContent( $none );
        $table->addContent( $all );
        $table->addContent( $template );

        // Input field
        $input = Xhtml::input( $this->value, $this->id )->type( InputXhtml::$TYPE_HIDDEN );
        $table->addContent( $input );

        $root->addContent( $table );
    }

    protected function drawContents( AbstractXhtml $root )
    {
        if ( !$this->contentFunction )
            return null;

        $func = $this->contentFunction;
        $func( $root, $this );
    }

    // /FUNCTIONS


}

?>