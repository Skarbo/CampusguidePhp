<?php

class FacilitiesCmsCampusguideMainController extends CmsCampusguideMainController
{

    // VARIABLES


    const PAGE_OVERVIEW = "overview";
    const PAGE_MAP = "map";
    const PAGE_FACILITY = "facility";

    const SUCCESS_FACILITY_ADDED = "facility_added";
    const SUCCESS_FACILITY_EDITED = "facility_edited";
    const SUCCESS_FACILITY_DELETED = "facility_deleted";

    public static $CONTROLLER_NAME = "facilities";

    /**
     * @var FacilityModel
     */
    private $facility;
    /**
     * @var FacilityModel
     */
    private $facilityAdmin;
    /**
     * @var FacilityListModel
     */
    private $facilities;
    /**
     * @var BuildingListModel
     */
    private $buildings;
    /**
     * @var FacilityValidator
     */
    private $facilityValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( Api $api, View $view )
    {
        parent::__construct( $api, $view );

        $this->setFacilityValidator( new FacilityValidator( $this->getLocale() ) );
        $this->setFacilities( new FacilityListModel() );
        $this->setBuildings( new BuildingListModel() );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


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
     * @return FacilityModel
     */
    public function getFacilityAdmin()
    {
        return $this->facilityAdmin;
    }

    /**
     * @param FacilityModel $facilityAdmin
     */
    public function setFacilityAdmin( FacilityModel $facilityAdmin )
    {
        $this->facilityAdmin = $facilityAdmin;
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
     * @return FacilityValidator
     */
    public function getFacilityValidator()
    {
        return $this->facilityValidator;
    }

    /**
     * @param FacilityValidator $facilityValidator
     */
    public function setFacilityValidator( FacilityValidator $facilityValidator )
    {
        $this->facilityValidator = $facilityValidator;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see CmsCampusguideMainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "%s - %s", "Facilites", parent::getTitle() );
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
        return "FacilitiesCmsCampusguideMainController";
    }

    /**
     * @see CmsCampusguideMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "FacilitiesCmsCampusguideMainView";
    }

    /**
     * @see CmsCampusguideMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return FacilitiesCmsCampusguideMainView::$ID_CMS_FACILITIES_WRAPPER;
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
     * @return boolean True if page is map
     */
    public function isPageMap()
    {
        return self::getPage() == self::PAGE_MAP;
    }

    /**
     * @return boolean True if page is map
     */
    public function isPageFacility()
    {
        return self::getPage() == self::PAGE_FACILITY;
    }

    // ... /IS


    // ... DO


    // ... ... PAGE


    /**
     * Do overview page
     */
    private function doOverviewPage()
    {

        // Set all Facilities
        $this->setFacilities( $this->getFacilityDao()->getAll() );

        // Set all Facilities' Buildings
        $this->setBuildings( $this->getBuildingDao()->getForeign( $this->getFacilities()->getIds() ) );

    }

    /**
     * Do Facility page
     */
    private function doFacilityPage()
    {

        // Get Facility id
        $facilityId = self::getId();

        // Get Facility
        $this->setFacility( $this->getFacilityDao()->get( $facilityId ) );

        // View action
        if ( $this->isActionView() )
        {
            $this->doFacilityViewAction();
        }
        // New action
        else if ( $this->isActionNew() )
        {
            $this->doFacilityNewAction();
        }
        // Edit action
        else if ( $this->isActionEdit() )
        {
            $this->doFacilityEditAction();
        }
        // Delete action
        else if ( $this->isActionDelete() )
        {
            $this->doFacilityDeleteAction();
        }

    }

    // ... ... /PAGE


    // ... ... ACTION


    /**
     * Do Facilit view action
     *
     * @throws BadrequestException
     */
    private function doFacilityViewAction()
    {

        // Facility must exist
        if ( !$this->getFacility() )
        {
            throw new BadrequestException( sprintf( "Facility \"%d\" does not exist", self::getId() ) );
        }

        // Set Facility Buildings
        $this->setBuildings( $this->getBuildingDao()->getForeign( array ( $this->getFacility()->getId() ) ) );

    }

    /**
     * Do Facility admin action
     *
     * @throws ValidatorException
     */
    private function doFacilityAdminAction()
    {

        // Set Facility admin from POST
        $this->setFacilityAdmin( new FacilityModel( self::getPost() ) );

        // Validate Facility admin
        $this->getFacilityValidator()->doValidate( $this->getFacilityAdmin(), "Invalid Facility" );

    }

    /**
     * Do Facility new action
     *
     * @throws BadrequestException
     */
    private function doFacilityNewAction()
    {

        // Set empty Facility as admin Facility
        $this->setFacilityAdmin( FacilityFactoryModel::createFacility( "" ) );

        // Is POST
        if ( self::isPost() )
        {

            // Do Facility admin action
            $this->doFacilityAdminAction();

            // Add Facility
            $facilityId = $this->getFacilityDao()->add( $this->getFacilityAdmin(), null );

            // Redirect
            Controller::redirect(
                    Resource::url()->campusguide()->cms()->facility()->getViewFacilityPage( $facilityId,
                            $this->getMode(),
                            Resource::url()->campusguide()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_ADDED ) ) );

        }

    }

    /**
     * Do Facility edit action
     *
     * @throws BadrequestException
     */
    private function doFacilityEditAction()
    {

        // Facility must exist
        if ( !$this->getFacility() )
        {
            throw new BadrequestException( sprintf( "Facility \"%d\" does not exist", self::getId() ) );
        }

        // Set Facility as admin Facility
        $this->setFacilityAdmin( $this->getFacility() );

        // Is POST
        if ( self::isPost() )
        {

            // Do Facility admin action
            $this->doFacilityAdminAction();

            // Edit Facility
            $this->getFacilityDao()->edit( $this->getFacility()->getId(), $this->getFacilityAdmin(), null );

            // Redirect
            Controller::redirect(
                    Resource::url()->campusguide()->cms()->facility()->getViewFacilityPage(
                            $this->getFacility()->getId(), $this->getMode(),
                            Resource::url()->campusguide()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_EDITED ) ) );

        }

    }

    /**
     * Do Facility delete action
     *
     * @throws BadrequestException
     */
    private function doFacilityDeleteAction()
    {

        // Id's must be given
        if ( !self::getIds() )
        {
            return;
        }

        // Set Facilities
        $this->setFacilities( $this->getFacilityDao()->getList( self::getIds() ) );

        // Is POST
        if ( self::isPost() )
        {

            // Delete Facilities
            for ( $this->getFacilities()->rewind(); $this->getFacilities()->valid(); $this->getFacilities()->next() )
            {
                $facility = $this->getFacilities()->current();

                $this->getFacilityDao()->remove( $facility->getId() );
            }

            // Redirect
            Controller::redirect(
                    Resource::url()->campusguide()->cms()->facility()->getOverviewPage( $this->getMode(),
                            Resource::url()->campusguide()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_DELETED ) ) );

        }

    }

    // ... ... /ACTION


    // ... /DO


    // ... REQUEST


    /**
     * @see CmsCampusguideMainController::after()
     */
    public function after()
    {
        parent::after();

        // Add Google maps on facility page, view action
        if ( $this->isPageFacility() && $this->isActionView() )
        {
            $this->addJavascriptMap();
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
            // Page map
            else if ( $this->isPageMap() )
            {

            }
            // Page Facility
            else if ( $this->isPageFacility() )
            {
                $this->doFacilityPage();
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

    // ... /REQUEST


    // /FUNCTIONS


}

?>