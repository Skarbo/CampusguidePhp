<?php

class AdminCmsMainController extends CmsMainController implements ErrorsAdminCmsInterfaceView, QueueAdminCmsInterfaceView
{

    // VARIABLES


    public static $CONTROLLER_NAME = "admin";

    const URI_TYPE = 4;

    const PAGE_ERRORS = "errors";
    const PAGE_QUEUE = "queue";

    const TYPE_SCHEDULEENTRIESROOM = "scheduleentriesroom";

    /**
     * @var ErrorListModel
     */
    private $errors;
    /**
     * @var QueueListModel
     */
    private $queues;
    /**
     * @var WebsiteScheduleListModel
     */
    private $websites;
    /**
     * @var FacilityListModel
     */
    private $facilities;

    /**
     * @var QueueHandler
     */
    private $queueHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->errors = new ErrorListModel();
        $this->queues = new QueueListModel();
        $this->websites = new WebsiteScheduleListModel();
        $this->facilities = new FacilityListModel();
        $this->queueHandler = new QueueHandler( $this->getDaoContainer(), new QueueValidator( $this->getLocale() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... IS


    public function isPageErrors()
    {
        return $this->getPage() == self::PAGE_ERRORS;
    }

    public function isPageQueue()
    {
        return $this->getPage() == self::PAGE_QUEUE;
    }

    public function isTypeScheduleEntriesRoom()
    {
        return $this->getTypeUri() == self::TYPE_SCHEDULEENTRIESROOM;
    }

    // ... /IS


    // ... GET


    /**
     * @see MainController::getControllerName()
     */
    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    /**
     * @see CmsMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "AdminCmsMainController";
    }

    /**
     * @see CmsMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "AdminCmsMainView";
    }

    /**
     * @see MainController::getErrors()
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @see QueueAdminCmsInterfaceView::getQueues()
     */
    public function getQueues()
    {
        return $this->queues;
    }

    /**
     * @see QueueAdminCmsInterfaceView::getWebsites()
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @see QueueAdminCmsInterfaceView::getFacilities()
     */
    public function getFacilities()
    {
        return $this->facilities;
    }

    // ... ... STATIC


    public static function getTypeUri()
    {
        return self::getURI( self::URI_TYPE );
    }

    // ... ... /STATIC


    // ... /GET


    public function doQueueRequest()
    {
        $this->queues = $this->getDaoContainer()->getQueueDao()->getList();
        $this->websites = $this->getDaoContainer()->getWebsiteScheduleDao()->getAll();
        $this->facilities = $this->getDaoContainer()->getFacilityDao()->getAll();

        if ( $this->isActionNew() && self::isPost() )
        {
            // Schedule Entries Room
            if ( $this->isTypeScheduleEntriesRoom() )
            {
                $websiteId = Core::arrayAt( self::getPost(), "select_website" );
                $facilityId = Core::arrayAt( self::getPost(), "select_facility" );
                $buildingId = Core::arrayAt( self::getPost(), "select_building" );
                $floorId = Core::arrayAt( self::getPost(), "select_floor" );

                $weekStart = strtotime(sprintf("+%s week", Core::arrayAt( self::getPost(), "week_start_week" )), strtotime(sprintf("01.01.%s", Core::arrayAt( self::getPost(), "week_start_year" ))));
                $weekEnd = strtotime(sprintf("+%s week", Core::arrayAt( self::getPost(), "week_end_week" )), strtotime(sprintf("01.01.%s", Core::arrayAt( self::getPost(), "week_end_year" ))));

                $website = $this->websites->getId( $websiteId );
                $facility = $this->facilities->getId( $facilityId );
                $building = $this->getDaoContainer()->getBuildingDao()->get( $buildingId );
                $floor = $this->getDaoContainer()->getFloorBuildingDao()->get( $floorId );

                if ( $website && $facility && $building && $floor )
                {
                    $rooms = $this->getDaoContainer()->getRoomScheduleDao()->getFloor( $floor->getId() );
                    $queue = QueueFactoryModel::createScheduleEntriesQueue( $website->getId(),
                            TypeScheduleModel::TYPE_ROOM, $rooms->getIds(), array( $weekStart, $weekEnd ) );
                    $this->queueHandler->handle( $queue );
                    self::redirect( Resource::url()->cms()->admin()->getQueuePage( $this->getMode() ) );
                }
                else
                {
                    var_dump( "Error", $_POST );
                }
            }
        }
    }

    public function before()
    {
        parent::before();
        if ( $this->isPageQueue() )
        {
            $this->addJavascriptFile( Resource::javascript()->getKnockoutApiFile() );
        }
    }

    public function request()
    {
        if ( $this->isPageErrors() )
        {
            $this->errors = $this->getDaoContainer()->getErrorDao()->getAll();
        }
        elseif ( $this->isPageQueue() )
        {
            $this->doQueueRequest();
        }
    }

    // /FUNCTIONS


}

?>