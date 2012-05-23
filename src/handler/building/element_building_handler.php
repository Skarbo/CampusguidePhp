<?php

class ElementBuildingHandler extends Handler
{

    // VARIABLES


    /**
     * @var TypeElementBuildingDao
     */
    private $elementBuildingDao;
    /**
     * @var SectionBuildingDao
     */
    private $sectionBuildingDao;
    /**
     * @var TypeTypeElementBuildingDao
     */
    private $typeTypeElementBuildingDao;
    /**
     * @var FloorBuildingDao
     */
    private $floorBuildingDao;
    /**
     * @var ElementBuildingValidator
     */
    private $elementBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( ElementBuildingDao $elementBuildingDao, SectionBuildingDao $sectionBuildingDao, TypeElementBuildingDao $typeElementBuildingDao, FloorBuildingDao $floorBuildingDao, ElementBuildingValidator $elementBuildingValidator )
    {
        $this->setElementBuildingDao( $elementBuildingDao );
        $this->setSectionBuildingDao( $sectionBuildingDao );
        $this->setTypeElementBuildingDao( $typeElementBuildingDao );
        $this->setFloorBuildingDao( $floorBuildingDao );
        $this->setElementBuildingValidator( $elementBuildingValidator );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return ElementBuildingDao
     */
    public function getElementBuildingDao()
    {
        return $this->elementBuildingDao;
    }

    /**
     * @param ElementBuildingDao $elementBuildingDao
     */
    public function setElementBuildingDao( ElementBuildingDao $elementBuildingDao )
    {
        $this->elementBuildingDao = $elementBuildingDao;
    }

    /**
     * @return SectionBuildingDao
     */
    public function getSectionBuildingDao()
    {
        return $this->sectionBuildingDao;
    }

    /**
     * @param SectionBuildingDao $sectionBuildingDao
     */
    public function setSectionBuildingDao( SectionBuildingDao $sectionBuildingDao )
    {
        $this->sectionBuildingDao = $sectionBuildingDao;
    }

    /**
     * @return TypeElementBuildingDao
     */
    public function getTypeElementBuildingDao()
    {
        return $this->typeTypeElementBuildingDao;
    }

    /**
     * @param TypeElementBuildingDao $elementBuildingDao
     */
    public function setTypeElementBuildingDao( TypeElementBuildingDao $elementBuildingDao )
    {
        $this->typeTypeElementBuildingDao = $elementBuildingDao;
    }

    /**
     * @return FloorBuildingDao
     */
    public function getFloorBuildingDao()
    {
        return $this->floorBuildingDao;
    }

    /**
     * @param FloorBuildingDao $floorBuildingDao
     */
    public function setFloorBuildingDao( FloorBuildingDao $floorBuildingDao )
    {
        $this->floorBuildingDao = $floorBuildingDao;
    }

    /**
     * @return ElementBuildingValidator
     */
    public function getElementBuildingValidator()
    {
        return $this->elementBuildingValidator;
    }

    /**
     * @param ElementBuildingValidator $elementBuildingValidator
     */
    public function setElementBuildingValidator( ElementBuildingValidator $elementBuildingValidator )
    {
        $this->elementBuildingValidator = $elementBuildingValidator;
    }

    // ... /GETTERS/SETTERS


    // ... HANDLE


    /**
     * @param int $buildingId
     * @param ElementBuildingModel $element
     * @return ElementBuildingModel
     * @throws ValidatorException
     */
    private function handleElement( $buildingId, ElementBuildingModel $element )
    {

        // Section should exist
        $section = $this->getSectionBuildingDao()->get( $element->getSectionId() );

        if ( !$section )
        {
            $element->setSectionId( null );
        }

        // Element Type should exist
        $elementType = $this->getTypeElementBuildingDao()->get( $element->getTypeId() );

        if ( !$elementType )
        {
            $element->setTypeId( null );
        }

        // Floor should exist
        $floor = $this->getFloorBuildingDao()->get( $element->getFloorId() );

        if ( !$floor )
        {
            $element->setFloorId( null );
        }

        // Validate Element
        $this->getElementBuildingValidator()->doValidate( $element );

        // Return Element
        return $element;

    }

    /**
     * Handle new Element
     *
     * @param int $buildingId
     * @param ElementBuildingModel $element
     * @return ElementBuildingModel
     * @throws ValidatorException
     */
    public function handleNewElement( $buildingId, ElementBuildingModel $element )
    {

        // Handle Element
        $element = $this->handleElement( $buildingId, $element );

        // Add Element
        $elementId = $this->getElementBuildingDao()->add( $element, $buildingId );

        // Get added Element
        $elementAdded = $this->getElementBuildingDao()->get( $elementId );

        // Return added Element
        return $elementAdded;

    }

    /**
     * Handle edit Element
     *
     * @param int $buildingId
     * @param ElementBuildingModel $element
     * @return ElementBuildingModel
     * @throws ValidatorException
     */
    public function handleEditElement( $buildingId, ElementBuildingModel $element )
    {

        // Handle Element
        $element = $this->handleElement( $buildingId, $element );

        // Edit Element
        $this->getElementBuildingDao()->edit( $element->getId(), $element, $buildingId );

        // Get edited Element
        $elementEdited = $this->getElementBuildingDao()->get( $element->getId() );

        // Return edited Element
        return $elementEdited;

    }

    // ... /HANDLE


    // /FUNCTIONS


}

?>