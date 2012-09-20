<?php

class BuildingsCmsCampusguideMainController extends CmsCampusguideMainController implements BuildingsCmsCampusguideInterfaceView, BuildingcreatorBuildingsCmsCampusguideInterfaceView
{

    // VARIABLES


    const URI_TYPE = 4;

    const TYPE_FLOORS = "floors";

    const PAGE_OVERVIEW = "overview";
    const PAGE_MAP = "map";
    const PAGE_BUILDING = "building";
    const PAGE_BUILDINGCREATOR = "buildingcreator";
    const PAGE_FLOORPLANNER = "floorplanner";

    const SUCCESS_BUILDING_ADDED = "building_added";
    const SUCCESS_BUILDING_EDITED = "building_edited";
    const SUCCESS_BUILDING_DELETED = "building_deleted";

    public static $CONTROLLER_NAME = "buildings";

    /**
     * @var BuildingModel
     */
    private $building;
    /**
     * @var FloorBuildingListModel
     */
    private $buildingFloors;
    /**
     * @var ElementBuildingListModel
     */
    private $buildingElements;
    /**
     * @var BuildingModel
     */
    private $buildingAdmin;
    /**
     * @var BuildingListModel
     */
    private $buildings;
    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var FacilityListModel
     */
    private $facilities;
    /**
     * @var BuildingValidator
     */
    private $buildingValidator;
    /**
     * @var FloorBuildingValidator
     */
    private $floorBuildingValidator;
    /**
     * @var FloorBuildingHandler
     */
    private $floorBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );
        $this->setFacilities( new FacilityListModel() );
        $this->setBuildingValidator( new BuildingValidator( $this->getLocale() ) );
        $this->setFloorBuildingValidator( new FloorBuildingValidator( $this->getLocale() ) );

        $this->setBuilding( BuildingFactoryModel::createBuilding( "", 0, array () ) );
        $this->setBuildingFloors( FloorBuildingFactoryModel::createFloorBuilding( 0, "", 0, array () ) );
        $this->setBuildingElements( new ElementBuildingListModel() );

        $this->setFloorBuildingHandler(
                new FloorBuildingHandler( $this->getCampusguideHandler()->getFloorBuildingDao(),
                        $this->getFloorBuildingValidator() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return BuildingModel
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param BuildingModel $building
     */
    private function setBuilding( BuildingModel $building )
    {
        $this->building = $building;
    }

    /**
     * @return FloorBuildingListModel
     */
    public function getBuildingFloors()
    {
        return $this->buildingFloors;
    }

    /**
     * @param FloorBuildingListModel $buildingFloors
     */
    private function setBuildingFloors( FloorBuildingListModel $buildingFloors )
    {
        $this->buildingFloors = $buildingFloors;
    }

    /**
     * @return BuildingModel
     */
    public function getBuildingAdmin()
    {
        return $this->buildingAdmin;
    }

    /**
     * @param BuildingModel $buildingAdmin
     */
    public function setBuildingAdmin( BuildingModel $buildingAdmin )
    {
        $this->buildingAdmin = $buildingAdmin;
    }

    /**
     * @return BuildingListModel
     */
    public function getBuildings()
    {
        return $this->buildings;
    }

    /**
     * @param BuildingListModel $buildings
     */
    public function setBuildings( BuildingListModel $buildings )
    {
        $this->buildings = $buildings;
    }

    /**
     * @see BuildingcreatorBuildingsCmsCampusguideInterfaceView::getBuildingElements()
     */
    public function getBuildingElements()
    {
        return $this->buildingElements;
    }

    /**
     * @param ElementBuildingListModel $buildingElements
     */
    public function setBuildingElements( ElementBuildingListModel $buildingElements )
    {
        $this->buildingElements = $buildingElements;
    }

    /**
     * @return FacilityModel
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * @param FacilityModel $facility
     */
    public function setFacility( FacilityModel $facility )
    {
        $this->facility = $facility;
    }

    /**
     * @return FacilityListModel
     */
    public function getFacilities()
    {
        return $this->facilities;
    }

    /**
     * @param FacilityListModel $facilities
     */
    public function setFacilities( FacilityListModel $facilities )
    {
        $this->facilities = $facilities;
    }

    /**
     * @return BuildingValidator
     */
    public function getBuildingValidator()
    {
        return $this->buildingValidator;
    }

    /**
     * @param BuildingValidator $buildingValidator
     */
    public function setBuildingValidator( BuildingValidator $buildingValidator )
    {
        $this->buildingValidator = $buildingValidator;
    }

    /**
     * @return FloorBuildingValidator
     */
    public function getFloorBuildingValidator()
    {
        return $this->floorBuildingValidator;
    }

    /**
     * @param FloorBuildingValidator $floorBuildingValidator
     */
    public function setFloorBuildingValidator( FloorBuildingValidator $floorBuildingValidator )
    {
        $this->floorBuildingValidator = $floorBuildingValidator;
    }

    /**
     * @return FloorBuildingHandler
     */
    private function getFloorBuildingHandler()
    {
        return $this->floorBuildingHandler;
    }

    /**
     * @param FloorBuildingHandler $buildingFloorsHandler
     */
    private function setFloorBuildingHandler( FloorBuildingHandler $buildingFloorsHandler )
    {
        $this->floorBuildingHandler = $buildingFloorsHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see CmsCampusguideMainController::getTitle()
     */
    public function getTitle()
    {
        return sprintf( "%s - %s", "Buildings", parent::getTitle() );
    }

    /**
     * @see CampusguideMainController::getControllerName()
     */
    public function getControllerName()
    {
        return self::$CONTROLLER_NAME;
    }

    /**
     * @see CmsCampusguideMainController::getJavascriptController()
     */
    protected function getJavascriptController()
    {
        return "BuildingsCmsCampusguideMainController";
    }

    /**
     * @see CmsCampusguideMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "BuildingsCmsCampusguideMainView";
    }

    /**
     * @see CmsCampusguideMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return BuildingsCmsCampusguideMainView::$ID_CMS_BUILDINGS_WRAPPER;
    }

    /**
     * @return string Type given i URI, null if none given
     */
    protected static function getType()
    {
        return self::getURI( self::URI_TYPE );
    }

    // ... /GET


    // ... IS


    /**
     * Default page
     *
     * @return boolean True if page is overview
     */
    public function isPageOverview()
    {
        return self::getPage() == self::PAGE_OVERVIEW || !self::getPage();
    }

    /**
     * @return boolean True if page is building
     */
    public function isPageBuilding()
    {
        return self::getPage() == self::PAGE_BUILDING;
    }

    /**
     * @return boolean True if page is buildingcreator
     */
    public function isPageBuildingcreator()
    {
        return self::getPage() == self::PAGE_BUILDINGCREATOR;
    }

    /**
     * @return boolean True if page is floorplanner
     */
    public function isPageFloorplanner()
    {
        return self::getPage() == self::PAGE_FLOORPLANNER;
    }

    /**
     * @return boolean True if type is floors
     */
    public function isTypeFloors()
    {
        return self::getType() == self::TYPE_FLOORS;
    }

    // ... /IS


    // ... CREATE


    /**
     * Create Floor list from POST
     *
     * @return FloorBuildingListModel
     */
    private function createFloorsPost()
    {

        $namePost = Core::arrayAt( self::getPost(), "floor_name", array () );
        $mapPost = Core::arrayAt( self::getPost(), "floor_map", array () );
        $orderPost = Core::arrayAt( self::getPost(), "floor_order", array () );
        $deletePost = Core::arrayAt( self::getPost(), "floor_delete", array () );
        $mainPost = Core::arrayAt( self::getPost(), "floor_main" );

        $floors = new FloorBuildingListModel();

        foreach ( $namePost as $id => $name )
        {
            if ( array_search( $id, $deletePost ) !== false )
            {
                continue;
            }

            $floor = FloorBuildingFactoryModel::createFloorBuilding( $this->getBuilding()->getId(), $name,
                    $orderPost[ $id ], array (), $mainPost == $id );
            $floor->setId( $id );

            if ( $floor->getId() == "new" && !$floor->getName() )
            {
                continue;
            }

            $floors->add( $floor );
        }

        return $floors;

    }

    // ... /CREATE


    // ... DO


    /**
     * Do overview page
     */
    private function doOverviewPage()
    {

        // Set Buildings
        $this->setBuildings( $this->getBuildingDao()->getAll() );

        // Get Facilit ids
        $facilityIds = $this->getBuildings()->getForeignIds();

        // Set Buildings' Facilities
        $this->setFacilities( $this->getFacilityDao()->getList( $facilityIds ) );

    }

    /**
     * Do Building page
     */
    private function doBuildingPage()
    {

        // Get Building id
        $buildingId = self::getId();

        // Set Building
        $this->setBuilding( $this->getBuildingDao()->get( $buildingId ) );

        // Set Facility
        if ( $this->getBuilding() )
        {
            $this->setFacility( $this->getFacilityDao()->get( $this->getBuilding()->getFacilityId() ) );
        }

        // View action
        if ( $this->isActionView() )
        {
            $this->doBuildingViewAction();
        }
        // New action
        else if ( $this->isActionNew() )
        {
            $this->doBuildingNewAction();
        }
        // Edit action
        else if ( $this->isActionEdit() )
        {
            $this->doBuildingEditAction();
        }

    }

    // ... ... BUILDING


    /**
     * Do Facilit view action
     *
     * @throws BadrequestException
     */
    private function doBuildingViewAction()
    {

    }

    /**
     * Do Building admin action
     *
     * @throws ValidatorException
     */
    private function doBuildingAdminAction()
    {

        // TODO: Remove Building coordinates
        // Create Building admin from POSt
        $this->setBuildingAdmin(
                BuildingFactoryModel::createBuilding(
                        Core::arrayAt( self::getPost(), Resource::db()->building()->getFieldName() ),
                        Core::arrayAt( self::getPost(), Resource::db()->building()->getFieldFacilityId() ),
                        "0,164|127,143|168,308|202,391|400,239|370,13|468,0|502,296|251,496|305,589|211,642|169,574|139,556|51,370",
                        Core::arrayAt( self::getPost(), Resource::db()->building()->getFieldAddress() ),
                        Core::arrayAt( self::getPost(), Resource::db()->building()->getFieldPosition() ),
                        Core::arrayAt( self::getPost(), Resource::db()->building()->getFieldLocation() ) ) );

        // Validate Building Facility
        $facility = $this->getFacilityDao()->get( $this->getBuildingAdmin()->getFacilityId() );

        // Facility must exist
        if ( !$facility )
        {
            $this->getBuildingAdmin()->setFacilityId( null );
        }

        // Validate Building admin
        $this->getBuildingValidator()->doValidate( $this->getBuildingAdmin(), "Invalid Building" );

    }

    /**
     * Do Facility new action
     *
     * @throws BadrequestException
     */
    private function doBuildingNewAction()
    {

        // Set empty Building as admin Building
        $this->setBuildingAdmin( BuildingFactoryModel::createBuilding( "", 0, array () ) );

        // Set all Facilities
        $this->setFacilities( $this->getFacilityDao()->getAll() );

        // Is POST
        if ( self::isPost() )
        {

            // Do Building admin action
            $this->doBuildingAdminAction();

            // Add Building
            $buildingId = $this->getBuildingDao()->add( $this->getBuildingAdmin(),
                    $this->getBuildingAdmin()->getFacilityId() );

            // Redirect
            self::redirect(
                    Resource::url()->campusguide()->cms()->building()->getViewBuildingPage( $buildingId,
                            $this->getMode(),
                            Resource::url()->campusguide()->cms()->getSuccessQuery( self::SUCCESS_BUILDING_ADDED ) ) );

        }

    }

    /**
     * Do Building edit action
     *
     * @throws BadrequestException
     */
    private function doBuildingEditAction()
    {

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( sprintf( "Building \"%d\" does not exist", self::getId() ) );
        }

        // Set Building as admin Building
        $this->setBuildingAdmin( $this->getBuilding() );

        // Set all Facilities
        $this->setFacilities( $this->getFacilityDao()->getAll() );

        // Is POST
        if ( self::isPost() )
        {

            // Do Building admin action
            $this->doBuildingAdminAction();

            // Edit Building
            $this->getBuildingDao()->edit( $this->getBuilding()->getId(), $this->getBuildingAdmin(),
                    $this->getBuildingAdmin()->getForeignId() );

            // Redirect
            self::redirect(
                    Resource::url()->campusguide()->cms()->building()->getViewBuildingPage(
                            $this->getBuilding()->getId(), $this->getMode(),
                            Resource::url()->campusguide()->cms()->getSuccessQuery( self::SUCCESS_BUILDING_EDITED ) ) );

        }

    }

    // ... ... /BUILDING


    // ... ... FLOORPLANNER


    /**
     * Do Floorplanner page
     */
    private function doFloorplannerPage()
    {

        // Get Building
        $this->setBuilding( $this->getBuildingDao()->get( self::getId() ) );

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( "Building does not exist" );
        }

    }

    // ... ... /FLOORPLANNER


    // ... ... BUILDINGCREATOR


    /**
     * Do Buildingcreator page
     *
     * @throws BadrequestException
     */
    private function doBuildingcreatorPage()
    {

        // Get Building
        $this->setBuilding( $this->getCampusguideHandler()->getBuildingDao()->get( self::getId() ) );

        // Building must exist
        if ( !$this->getBuilding() )
        {
            throw new BadrequestException( "Building does not exist" );
        }

        // Get floors
        $this->setBuildingFloors(
                $this->getCampusguideHandler()->getFloorBuildingDao()->getForeign(
                        array ( $this->getBuilding()->getId() ) ) );

        // Get Elements
        $this->setBuildingElements(
                $this->getCampusguideHandler()->getElementBuildingDao()->getBuilding( $this->getBuilding()->getId() ) );

        // POST


        // Edit Floors
        if ( self::isPost() && self::isActionEdit() && self::isTypeFloors() )
        {

            // Get created Floors from post
            $floors = $this->createFloorsPost();

            // Get new Floor
            $floorNew = $floors->removeId( "new" );

            // Sort floors
            $floors->sortByOrder();

            // Delete floors
            $floorsDelete = Core::arrayAt( self::getPost(), "floor_delete", array () );

            foreach ( $floorsDelete as $floorId )
            {
                $this->getCampusguideHandler()->getFloorBuildingDao()->remove( $floorId );
            }

            // Edit floors
            $floors = $this->getFloorBuildingHandler()->handleEditFloors( $this->getBuilding()->getId(),
                    $floors );

            // New floor
            if ( $floorNew )
            {
                $floorNew = $this->getFloorBuildingHandler()->handleAddFloor( $this->getBuilding()->getId(), $floorNew );
            }

            // MAP


            $floorsMaps = Core::arrayAt( self::getFiles(), "floor_map" );
            DebugHandler::doDebug( DebugHandler::LEVEL_LOW, new DebugException( "Floors maps", $floorsMaps ) );
            if ( key_exists( "new", $floorsMaps ) )
            {
                $this->doMapFloor( $floorNew, $floorsMaps[ "new" ] );
            }

            for ( $floors->rewind(); $floors->valid(); $floors->next() )
            {
                $floor = $floors->current();
                if ( key_exists( $floor->getId(), $floorsMaps ) )
                {
                    $this->doMapFloor( $floor, $floorsMaps[ $floor->getId() ] );
                }
            }

            // /MAP


            // Redirect
            self::redirect(
                    Resource::url()->campusguide()->cms()->building()->getBuildingcreatorViewPage(
                            $this->getBuilding()->getId(), $this->getMode( true ) ) );

        }

        // /POST


    }

    private function doMapFloor( FloorBuildingModel $floor, array $floorFile )
    {
        if ( !$floorFile[ "name" ] )
        {
            return false;
        }

        if ( $floorFile[ "error" ] == UPLOAD_ERR_OK )
        {
            $floorMapPath = Resource::image()->campusguide()->building()->getBuildingFloorMap(
                    $this->getBuilding()->getId(), $floor->getId(), $this->getMode() );

            Core::createFolders( $floorMapPath );

            $moved = move_uploaded_file( $floorFile[ "tmp_name" ], $floorMapPath );
        }
        else if ( $floorFile[ "error" ] != UPLOAD_ERR_NO_FILE )
        {
            DebugHandler::doDebug( DebugHandler::LEVEL_HIGH,
                    new DebugException( "Floor error", $floor, $floorFile[ "error" ] ) );
        }

    }

    // ... ... /BUILDINGCREATOR


    // ... /DO


    /**
     * @see CmsCampusguideMainController::after()
     */
    public function after()
    {
        parent::after();

        // Add Google maps on building page, edit/new action
        if ( $this->isPageBuilding() && ( $this->isActionNew() || $this->isActionEdit() ) )
        {
            $this->addJavascriptMap();
            $this->addJavascriptFile( Resource::javascript()->getJqueryHistoryApiFile() );
        }

        // Add Kinectic api, canvas
        if ( ( $this->isPageFloorplanner() || $this->isPageBuildingcreator() ) && self::getId() )
        {
            $this->addJavascriptFile( Resource::javascript()->getKineticApiFile() );
            $this->addJavascriptFile( Resource::javascript()->getJavascriptCanvasFile( $this->getMode() ) );
        }

    }

    /**
     * @see Controller::request()
     */
    public function request()
    {
        parent::request();

        try
        {

            // Page overview
            if ( $this->isPageOverview() )
            {
                $this->doOverviewPage();
            }
            // Page Building
            else if ( $this->isPageBuilding() )
            {
                $this->doBuildingPage();
            }
            // Building creator
            else if ( $this->isPageBuildingcreator() )
            {
                $this->doBuildingcreatorPage();
            }
            // Floor planner
            else if ( $this->isPageFloorplanner() )
            {
                $this->doFloorplannerPage();
            }
            // Bad request
            else
            {
                throw new BadrequestException( sprintf( "Page \"%s\" does not exist", self::getPage() ) );
            }

        }
        catch ( BadrequestException $e )
        {
            $this->addError( $e );
        }
        catch ( ValidatorException $e )
        {
            $this->addError( $e );
        }

    }

    // /FUNCTIONS


}

?>