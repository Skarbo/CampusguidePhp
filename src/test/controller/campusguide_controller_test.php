<?php

abstract class CampusguideControllerTest extends WebTest
{

    // VARIABLES


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
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    public function setUp()
    {
        parent::setUp();

        $this->facilityDao->removeAll();
        $this->buildingDao->removeAll();
        $this->sectionBuildingDao->removeAll();
        $this->elementBuildingDao->removeAll();
        $this->typeElementBuildingDao->removeAll();
        $this->groupTypeElementBuildingDao->removeAll();
        $this->floorBuildingDao->removeAll();
    }

    // ... GET


    public static function getRestWebsite( $arguments )
    {
        return sprintf( "http://%s%s/api_rest.php?/%s&mode=3", $_SERVER[ "HTTP_HOST" ],
                dirname( $_SERVER[ "REQUEST_URI" ] ), $arguments );
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
    protected function addElement( $floorId, $elementTypeId = null, $sectionId = null )
    {
        $element = ElementBuildingDaoTest::createElementBuildingTest( $floorId, $elementTypeId,
                $sectionId );

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