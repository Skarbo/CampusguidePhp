<?php

class ElementBuildingHandler extends Handler
{

    // VARIABLES


    /**
     * @var ElementBuildingDao
     */
    private $elementBuildingDao;
    /**
     * @var SectionBuildingDao
     */
    private $sectionBuildingDao;
    /**
     * @var ElementBuildingValidator
     */
    private $elementBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( ElementBuildingDao $elementBuildingDao, SectionBuildingDao $sectionBuildingDao, ElementBuildingValidator $elementBuildingValidator )
    {
        $this->setElementBuildingDao( $elementBuildingDao );
        $this->setSectionBuildingDao( $sectionBuildingDao );
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
    private function handleElement( $floorId, ElementBuildingModel $element )
    {

        // Section should exist
        $section = $this->getSectionBuildingDao()->get( $element->getSectionId() );

        if ( !$section )
        {
            $element->setSectionId( null );
        }

        // Validate Element
        $this->getElementBuildingValidator()->doValidate( $element );

        // Return Element
        return $element;

    }

    /**
     * Handle new Element
     *
     * @param int $floorId
     * @param ElementBuildingModel $element
     * @return ElementBuildingModel
     * @throws ValidatorException
     */
    public function handleNewElement( $floorId, ElementBuildingModel $element )
    {

        // Handle Element
        $element = $this->handleElement( $floorId, $element );

        // Add Element
        $elementId = $this->getElementBuildingDao()->add( $element, $floorId );

        // Get added Element
        $elementAdded = $this->getElementBuildingDao()->get( $elementId );

        // Return added Element
        return $elementAdded;

    }

    /**
     * Handle edit Element
     *
     * @param int $floorId
     * @param ElementBuildingModel $element
     * @return ElementBuildingModel
     * @throws ValidatorException
     */
    public function handleEditElement( $elementId, ElementBuildingModel $element, $floorId )
    {

        // Handle Element
        $element = $this->handleElement( $floorId, $element );

        // Edit Element
        $this->getElementBuildingDao()->edit( $elementId, $element, $floorId );

        // Get edited Element
        $elementEdited = $this->getElementBuildingDao()->get( $elementId );

        // Return edited Element
        return $elementEdited;

    }

    // ... /HANDLE


    // /FUNCTIONS


}

?>