<?php

abstract class CampusguideDaoTest extends DbTest
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
     * @var ElementBuildingDao
     */
    protected $elementBuildingDao;
    /**
     * @var FloorBuildingDao
     */
    protected $floorBuildingDao;
    /**
     * @var TypeElementBuildingDao
     */
    protected $typeElementBuildingDao;
    /**
     * @var GroupTypeElementBuildingDao
     */
    protected $groupTypeElementBuildingDao;

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

    // ... CREATE


    /**
     * @return FacilityModel
     */
    public static function createFacilityTest()
    {
        $facility = FacilityFactoryModel::createFacility( "Test Facility" );

        return $facility;
    }

    /**
     * @return BuildingModel
     */
    public static function createBuildingTest( $facilityId )
    {
        $building = BuildingFactoryModel::createBuilding( "Test Building", $facilityId,
                array ( array ( 100, 200 ), array ( 300, 400 ) ) );

        return $building;
    }

    /**
     * @return FloorBuildingModel
     */
    public static function createFloorBuildingTest( $buildingId )
    {
        $floorBuilding = FloorBuildingFactoryModel::createFloorBuilding( $buildingId, "Test Floor", 0,  array( array ( array ( 100, 200, "L" ), array ( 300, 400, "L" ) ) ) );

        return $floorBuilding;
    }

    /**
     * @return ElementBuildingModel
     */
    public static function createElementBuildingTest( $floorId, $elementTypeId, $sectionId )
    {
        $elementBuilding = ElementBuildingFactoryModel::createElementBuilding( $floorId, "Test Room",
                array( array ( array ( 100, 200, "L" ), array ( 300, 400, "L" ) ) ), $elementTypeId, $sectionId );

        return $elementBuilding;
    }

    /**
     * @return TypeElementBuildingModel
     */
    public static function createTypeElementBuildingTest( $groupId )
    {
        $typeElementBuilding = TypeElementBuildingFactoryModel::createTypeElementBuilding( $groupId, "Test Element Building",
                "icon1" );

        return $typeElementBuilding;
    }

    /**
     * @return GroupTypeElementBuildingModel
     */
    public static function createGroupTypeElementBuildingTest()
    {
        $groupTypeElementBuilding = GroupTypeElementBuildingFactoryModel::createGroupTypeElementBuilding( "Test Group Type Element Building" );

        return $groupTypeElementBuilding;
    }

    /**
     * @return SectionBuildingModel
     */
    public static function createSectionBuildingTest( $buildingId )
    {
        $sectionBuilding = SectionBuildingFactoryModel::createSectionBuilding( $buildingId, "Section Test",
                array ( array ( 100, 200 ), array ( 300, 400 ) ) );

        return $sectionBuilding;
    }

    // ... /CREATE


    // ... ADD


    /**
     * @return FacilityModel
     */
    protected function addFacility()
    {
        $facility = self::createFacilityTest();

        $facility->setId( $this->facilityDao->add( $facility, null ) );

        return $facility;
    }

    /**
     * @return BuildingModel
     */
    protected function addBuilding( $facilityId )
    {
        $building = self::createBuildingTest( $facilityId );

        $building->setId( $this->buildingDao->add( $building, $facilityId ) );

        return $building;
    }

    /**
     * @return SectionBuildingModel
     */
    protected function addSection( $buildingId )
    {
        $section = self::createSectionBuildingTest( $buildingId );

        $section->setId( $this->sectionBuildingDao->add( $section, $buildingId ) );

        return $section;
    }

    /**
     * @return RoomBuildingModel
     */
    protected function addElement( $floorId, $elementTypeId, $sectionId )
    {
        $element = self::createElementBuildingTest( $floorId, $elementTypeId, $sectionId );

        $element->setId( $this->elementBuildingDao->add( $element, $floorId ) );

        return $element;
    }

    /**
     * @return TypeElementBuildingModel
     */
    protected function addTypeElement( $elementTypeGroupId )
    {
        $typeElement = self::createTypeElementBuildingTest( $elementTypeGroupId );

        $typeElement->setId( $this->typeElementBuildingDao->add( $typeElement, $elementTypeGroupId ) );

        return $typeElement;
    }

    /**
     * @return GroupTypeElementBuildingModel
     */
    protected function addGroupTypeElement()
    {
        $groupTypeElement = self::createGroupTypeElementBuildingTest();

        $groupTypeElement->setId( $this->groupTypeElementBuildingDao->add( $groupTypeElement, null ) );

        return $groupTypeElement;
    }

    /**
     * @return FloorBuildingModel
     */
    protected function addFloor( $buildingId )
    {
        $floor = self::createFloorBuildingTest( $buildingId );

        $floor->setId( $this->floorBuildingDao->add( $floor, $buildingId ) );

        return $floor;
    }

    // ... /ADD


    // /FUNCTIONS


}

?>