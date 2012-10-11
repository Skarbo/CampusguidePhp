<?php

class QueueAdminCmsPageMainView extends PageCmsPageMainView implements QueueAdminCmsInterfaceView
{

    // VARIABLES


    private static $ID_QUEUE_WRAPPER = "queue_page_wrapper";

    /**
     * @var SliderCmsPresenterView
     */
    private $facilitySliderPresenter;
    /**
     * @var SliderCmsPresenterView
     */
    private $buildingSliderPresenter;
    /**
     * @var SliderCmsPresenterView
     */
    private $floorSliderPresenter;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( AbstractMainView $view )
    {
        parent::__construct( $view );
        $this->facilitySliderPresenter = new SelectsliderCmsPresenterView( $view, "select_facility",
                Resource::url()->cms()->facility()->getViewFacilityPage( "%s", $this->getMode() ),
                Resource::url()->cms()->facility()->getFacilityImage( "%s", 200, 100, $this->getMode() ) );
        $this->buildingSliderPresenter = new SelectsliderCmsPresenterView( $view, "select_building",
                Resource::url()->cms()->building()->getViewBuildingPage( "%s", $this->getMode() ),
                Resource::url()->cms()->building()->getBuildingOverviewImage( "%s", 200, 100, $this->getMode() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see AbstractPageMainView::getView()
     * @return AdminCmsMainView
     */
    public function getView()
    {
        return parent::getView();
    }

    /**
     * @see PageCmsPageMainView::getWrapperId()
     */
    protected function getWrapperId()
    {
        return self::$ID_QUEUE_WRAPPER;
    }

    /**
     * @see QueueAdminCmsInterfaceView::getQueues()
     */
    public function getQueues()
    {
        return $this->getView()->getQueues();
    }

    /**
     * @see QueueAdminCmsInterfaceView::getWebsites()
     */
    public function getWebsites()
    {
        return $this->getView()->getWebsites();
    }

    /**
     * @see QueueAdminCmsInterfaceView::getFacilities()
     */
    public function getFacilities()
    {
        return $this->getView()->getFacilities();
    }

    // ... /GET


    /**
     * @see PageCmsPageMainView::drawHeader()
     */
    protected function drawHeader( AbstractXhtml $root )
    {
        if ( $this->isActionNew() )
            $root->addContent( Xhtml::h( 2, "New Queue" ) );
        else
            $root->addContent( Xhtml::h( 2, sprintf( "Queue (%d)", $this->getQueues()->size() ) ) );
    }

    /**
     * @see PageCmsPageMainView::drawBody()
     */
    protected function drawBody( AbstractXhtml $root )
    {
        if ( $this->isActionNew() )
        {
            $this->drawNewQueue( $root );
        }
        else
        {
            $this->drawQueues( $root );
        }
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawQueues( AbstractXhtml $root )
    {
        $table = Xhtml::table()->class_( "queues", "cms_table" );

        $thead = Xhtml::thead();
        $tr = Xhtml::tr();
        $tr->addContent( Xhtml::td( "#" )->class_( "id" ) );
        $tr->addContent( Xhtml::td( "Type" )->class_( "type" ) );
        $tr->addContent( Xhtml::td( "Priority" )->class_( "priority" ) );
        $tr->addContent( Xhtml::td( "Arguments" )->class_( "arguments" ) );
        $tr->addContent( Xhtml::td( "Building" )->class_( "building" ) );
        $tr->addContent( Xhtml::td( "Website" )->class_( "website" ) );
        $tr->addContent( Xhtml::td( "Schedule" )->class_( "schedule" ) );
        $tr->addContent( Xhtml::td( "Occurence" )->class_( "occurence" ) );
        $tr->addContent( Xhtml::td( "Error" )->class_( "error" ) );
        $tr->addContent( Xhtml::td( "Activity" )->class_( "activity" ) );
        $thead->addContent( $tr );
        $table->addContent( $thead );

        $tbody = Xhtml::tbody();
        for ( $this->getQueues()->rewind(); $this->getQueues()->valid(); $this->getQueues()->next() )
        {
            $queue = $this->getQueues()->current();

            $tr = Xhtml::tr();

            $tr->addContent( Xhtml::td( $queue->getId() )->class_( "id" ) );
            $tr->addContent( Xhtml::td( $queue->getType() )->class_( "type" ) );
            $tr->addContent( Xhtml::td( $queue->getPriority() )->class_( "priority" ) );
            $tr->addContent(
                    Xhtml::td( urldecode( QueueUtil::generateArgumentsToString( $queue->getArguments() ) ) )->class_(
                            "arguments" ) );
            $tr->addContent( Xhtml::td( $queue->getBuildingId() )->class_( "building" ) );
            $tr->addContent( Xhtml::td( $queue->getWebsiteId() )->class_( "website" ) );
            $tr->addContent( Xhtml::td( $queue->getScheduleType() )->class_( "schedule" ) );
            $tr->addContent( Xhtml::td( $queue->getOccurence() )->class_( "occurence" ) );
            $tr->addContent( Xhtml::td( $queue->getError() )->class_( "error" ) );
            $tr->addContent(
                    Xhtml::td( $this->getLocale()->timeSince( max( $queue->getUpdated(), $queue->getRegistered() ) ) )->class_(
                            "activity" ) );

            $tbody->addContent( $tr );
        }
        $table->addContent( $tbody );

        $tfoot = Xhtml::tfoot()->class_( !$this->getQueues()->isEmpty() ? Resource::css()->getHide() : "" );
        $tfoot->addContent( Xhtml::tr( Xhtml::td( "No queues" )->colspan( 10 ) ) );
        $table->addContent( $tfoot );

        $root->addContent( $table );
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawNewQueue( AbstractXhtml $root )
    {
        $this->drawNewQueueScheduleEntriesRoom( $root );
    }

    /**
     * @param AbstractXhtml $root
     */
    private function drawNewQueueScheduleEntriesRoom( AbstractXhtml $root )
    {
        $form = Xhtml::form()->action(
                Resource::url()->cms()->admin()->getQueuePageNewScheduleEntriesRoom( $this->getMode() ) )->method(
                FormXhtml::$METHOD_POST )->autocomplete( false );
        $fields = Xhtml::div()->class_( Resource::css()->cms()->getFields() );

        $root->addContent( Xhtml::h( 3, "Schedule Room Entries" ) );

        // WEBSITE


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( "Website" ) );

        $selectWebsite = Xhtml::select()->name( "select_website" );
        for ( $this->getWebsites()->rewind(); $this->getWebsites()->valid(); $this->getWebsites()->next() )
        {
            $website = $this->getWebsites()->current();
            $selectWebsite->addContent( Xhtml::option( $website->getUrl(), $website->getId() ) );
        }
        $field->addContent( Xhtml::div( $selectWebsite ) );
        $fields->addContent( $field );

        // /WEBSITE


        // FACILITY


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( "Facility" )->class_( Resource::css()->cms()->getRequired() ) );
        $facilities = $this->getFacilities();
        $this->facilitySliderPresenter->setContentFunction(
                function ( AbstractXhtml $root, SelectsliderCmsPresenterView $slider ) use($facilities )
                {
                    for ( $facilities->rewind(); $facilities->valid(); $facilities->next() )
                    {
                        $facility = $facilities->current();
                        $root->addContent(
                                $slider->createContent( $facility->getId(),
                                        Resource::url()->cms()->facility()->getFacilityImage( $facility->getId(), 200,
                                                100, $slider->getMode() ), $facility->getName(),
                                        Resource::url()->cms()->facility()->getViewFacilityPage( $facility->getId(),
                                                $slider->getMode() ) ) );
                    }
                } );
        $facilitySlider = Xhtml::div();
        $this->facilitySliderPresenter->draw( $facilitySlider );
        $field->addContent( $facilitySlider );
        $fields->addContent( $field );

        // /FACILITY


        // BUILDING


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( "Building" )->class_( Resource::css()->cms()->getRequired() ) );
        $buildingSlider = Xhtml::div();
        $this->buildingSliderPresenter->draw( $buildingSlider );
        $field->addContent( $buildingSlider );
        $fields->addContent( $field );

        // /BUILDING


        // FLOOR


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( "Floor" )->class_( Resource::css()->cms()->getRequired() ) );
        $field->addContent( Xhtml::select()->name( "select_floor" ) );
        $fields->addContent( $field );

        // /FLOOR


        // WEEK


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( "Weeks" )->class_( Resource::css()->cms()->getRequired() ) );

        $weekStartSelect = Xhtml::select()->name("week_start_week");
        $weekCurrent = intval( date( "W" ) );
        for ( $i = 1; $i < 53; $i++ )
        {
            $value = ( ( ( $i + $weekCurrent ) % 53 ) + 1 );
            $weekStartSelect->addContent( Xhtml::option( $value )->value($value) );
        }
        $year = intval(date("Y"));
        $weekYearStartSelect = Xhtml::select(Xhtml::option($year)->value($year))->name("week_start_year")->addContent(Xhtml::option($year)->value($year));
        $field->addContent( "Start", $weekStartSelect, $weekYearStartSelect);

        $weekEndSelect = Xhtml::select()->name("week_end_week");;
        for ( $i = 1; $i < 53; $i++ )
        {
            $value = ( ( ( $i + $weekCurrent + 1 ) % 53 ) + 1 );
            $weekEndSelect->addContent( Xhtml::option( $value )->value($value) );
        }
        $weekYearEndSelect = Xhtml::select(Xhtml::option($year)->value($year))->name("week_end_year")->addContent(Xhtml::option($year)->value($year));
        $field->addContent("End", $weekEndSelect, $weekYearEndSelect);

        $fields->addContent( $field );

        // /WEEK


        // ADD QUEUE


        $field = Xhtml::div();
        $field->addContent( Xhtml::div( Xhtml::$NBSP ) );
        $field->addContent(
                Xhtml::div(
                        Xhtml::div(
                                Xhtml::div( "Add Queue" )->class_( Resource::css()->gui()->getComponent() )->attr(
                                        "data-disabled", "true" )->id( "queue_schedule_add" ) )->class_(
                                Resource::css()->gui()->getGui(), "theme2" ) )->class_( Resource::css()->getRight() ) );
        $fields->addContent( $field );

        // /ADD QUEUE


        $form->addContent( $fields );
        $root->addContent( $form );
    }

    // /FUNCTIONS


}

?>