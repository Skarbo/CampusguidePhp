<?php

class FacilitiesCmsMainController extends CmsMainController
{

    // VARIABLES


    const PAGE_FACILITY = "facility";
    const PAGE_MAP = "map";

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
     * @see CmsMainController::getTitle()
     */
    protected function getTitle()
    {
        return sprintf( "%s - %s", "Facilites", parent::getTitle() );
    }

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
        return "FacilitiesCmsMainController";
    }

    /**
     * @see CmsMainController::getJavascriptView()
     */
    protected function getJavascriptView()
    {
        return "FacilitiesCmsMainView";
    }

    /**
     * @see CmsMainController::getViewWrapperId()
     */
    protected function getViewWrapperId()
    {
        return FacilitiesCmsMainView::$ID_CMS_FACILITIES_WRAPPER;
    }

    // ... /GET


    // ... IS

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
        $this->setFacilities( $this->getDaoContainer()->getFacilityDao()->getAll() );

        // Set all Facilities' Buildings
        $this->setBuildings( $this->getDaoContainer()->getBuildingDao()->getForeign( $this->getFacilities()->getIds() ) );

    }

    /**
     * Do Facility page
     */
    private function doFacilityPage()
    {

        // Get Facility id
        $facilityId = self::getId();

        // Get Facility
        $this->setFacility( $this->getDaoContainer()->getFacilityDao()->get( $facilityId ) );

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
        $this->setBuildings( $this->getDaoContainer()->getBuildingDao()->getForeign( array ( $this->getFacility()->getId() ) ) );

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
            AbstractController::redirect(
                    Resource::url()->cms()->facility()->getViewFacilityPage( $facilityId,
                            $this->getMode(),
                            Resource::url()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_ADDED ) ) );

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
            AbstractController::redirect(
                    Resource::url()->cms()->facility()->getViewFacilityPage(
                            $this->getFacility()->getId(), $this->getMode(),
                            Resource::url()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_EDITED ) ) );

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
            AbstractController::redirect(
                    Resource::url()->cms()->facility()->getOverviewPage( $this->getMode(),
                            Resource::url()->cms()->getSuccessQuery( self::SUCCESS_FACILITY_DELETED ) ) );

        }

    }

    // ... ... /ACTION


    // ... /DO


    // ... REQUEST


    /**
     * @see CmsMainController::after()
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
     * @see AbstractController::request()
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