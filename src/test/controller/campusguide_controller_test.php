<?php

abstract class CampusguideControllerTest extends WebTest
{

    // VARIABLES


    private static $PAGE_COMMAND = "command.php";
    private static $PAGE_API_REST = "api_rest.php";

    /**
     * @var FacilityDao
     */
    protected $facilityDao;
    /**
     * @var SectionBuildingDao
     */
    protected $sectionBuildingDao;
    /**
     * @var BuildingDao
     */
    protected $buildingDao;
    /**
     * @var TypeElementBuildingDao
     */
    protected $elementBuildingDao;
    /**
     * @var TypeElementBuildingDao
     */
    protected $typeElementBuildingDao;
    /**
     * @var GroupTypeElementBuildingDao
     */
    protected $groupTypeElementBuildingDao;
    /**
     * @var FloorBuildingDao
     */
    protected $floorBuildingDao;
    /**
     * @var CampusguideHandlerTest
     */
    protected $campusguideHandlerTest;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $label )
    {
        parent::__construct( $label );

        $this->facilityDao = new FacilityDbDao( $this->getDbApi() );
        $this->buildingDao = new BuildingDbDao( $this->getDbApi() );
        $this->sectionBuildingDao = new SectionBuildingDbDao( $this->getDbApi() );
        $this->elementBuildingDao = new ElementBuildingDbDao( $this->getDbApi() );
        $this->typeElementBuildingDao = new TypeElementBuildingDbDao( $this->getDbApi() );
        $this->groupTypeElementBuildingDao = new GroupTypeElementBuildingDbDao( $this->getDbApi() );
        $this->floorBuildingDao = new FloorBuildingDbDao( $this->getDbApi() );

        $this->campusguideHandlerTest = new CampusguideHandlerTest($this->getDbApi());
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->getCampusguideHandlerTest()->removeAll();

        $this->facilityDao->removeAll();
        $this->buildingDao->removeAll();
        $this->sectionBuildingDao->removeAll();
        $this->elementBuildingDao->removeAll();
        $this->typeElementBuildingDao->removeAll();
        $this->groupTypeElementBuildingDao->removeAll();
        $this->floorBuildingDao->removeAll();
    }

    // ... GET


    public static function getCommandWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_COMMAND, $arguments );
    }

    public static function getRestWebsite( $arguments )
    {
        return self::getWebsiteApi( self::$PAGE_API_REST, $arguments );
    }

    /**
     * @return CampusguideHandlerTest
     */
    public function getCampusguideHandlerTest()
    {
        return $this->campusguideHandlerTest;
    }

    // ... /GET


    // ... ADD


    /**
     * @return FacilityModel
     */
    protected function addFacility()
    {
        $facility = FacilityDaoTest::createFacilityTest();

        $facility->setId( $this->facilityDao->add( $facility, null ) );

        return $facility;
    }

    /**
     * @return BuildingModel
     */
    protected function addBuilding( $facilityId )
    {
        $building = BuildingDaoTest::createBuildingTest( $facilityId );

        $building->setId( $this->buildingDao->add( $building, $facilityId ) );

        return $building;
    }

    /**
     * @return SectionBuildingModel
     */
    protected function addSection( $buildingId )
    {
        $section = SectionBuildingDaoTest::createSectionBuildingTest( $buildingId );

        $section->setId( $this->sectionBuildingDao->add( $section, $buildingId ) );

        return $section;
    }

    /**
     * @return ElementBuildingModel
     */
    protected function addElement( $floorId, $sectionId = null, $type = "", $typeGroup = "" )
    {
        $element = ElementBuildingDaoTest::createElementBuildingTest( $floorId, $sectionId, $type, $typeGroup );

        $element->setId( $this->elementBuildingDao->add( $element, $floorId ) );

        return $element;
    }

    /**
     * @return TypeElementBuildingModel
     */
    protected function addTypeElement( $elementTypeGroupId )
    {
        $elementType = TypeElementBuildingDaoTest::createTypeElementBuildingTest( $elementTypeGroupId );

        $elementType->setId( $this->typeElementBuildingDao->add( $elementType, $elementTypeGroupId ) );

        return $elementType;
    }

    /**
     * @return GroupTypeElementBuildingModel
     */
    protected function addGroupTypeElement()
    {
        $elementTypeGroup = GroupTypeElementBuildingDaoTest::createGroupTypeElementBuildingTest();

        $elementTypeGroup->setId( $this->groupTypeElementBuildingDao->add( $elementTypeGroup, null ) );

        return $elementTypeGroup;
    }

    /**
     * @return FloorBuildingModel
     */
    protected function addFloor( $buildingId )
    {
        $floor = FloorBuildingDaoTest::createFloorBuildingTest( $buildingId );

        $floor->setId( $this->floorBuildingDao->add( $floor, $buildingId ) );

        return $floor;
    }

    // ... /ADD


    // /FUNCTIONS


}

?>