<?php

class TypeElementBuildingHandler extends Handler
{

    // VARIABLES


    /**
     * @var TypeElementBuildingDao
     */
    private $typeElementBuildingDao;
    /**
     * @var GroupTypeElementBuildingDao
     */
    private $groupTypeElementBuildingDao;
    /**
     * @var TypeElementBuildingValidator
     */
    private $typeElementBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( TypeElementBuildingDao $typeElementBuildingDao, GroupTypeElementBuildingDao $groupTypeElementBuildingDao, TypeElementBuildingValidator $typeElementBuildingValidator )
    {
        $this->setTypeElementBuildingDao( $typeElementBuildingDao );
        $this->setGroupTypeElementBuildingDao( $groupTypeElementBuildingDao );
        $this->setTypeElementBuildingValidator( $typeElementBuildingValidator );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return TypeElementBuildingDao
     */
    public function getTypeElementBuildingDao()
    {
        return $this->typeElementBuildingDao;
    }

    /**
     * @param TypeElementBuildingDao $typeElementBuildingDao
     */
    public function setTypeElementBuildingDao( TypeElementBuildingDao $typeElementBuildingDao )
    {
        $this->typeElementBuildingDao = $typeElementBuildingDao;
    }

    /**
     * @return GroupTypeElementBuildingDao
     */
    public function getGroupTypeElementBuildingDao()
    {
        return $this->groupTypeElementBuildingDao;
    }

    /**
     * @param GroupTypeElementBuildingDao $groupTypeElementBuildingDao
     */
    public function setGroupTypeElementBuildingDao( GroupTypeElementBuildingDao $groupTypeElementBuildingDao )
    {
        $this->groupTypeElementBuildingDao = $groupTypeElementBuildingDao;
    }

    /**
     * @return TypeElementBuildingValidator
     */
    public function getTypeElementBuildingValidator()
    {
        return $this->typeElementBuildingValidator;
    }

    /**
     * @param TypeElementBuildingValidator $typeElementBuildingValidator
     */
    public function setTypeElementBuildingValidator( TypeElementBuildingValidator $typeElementBuildingValidator )
    {
        $this->typeElementBuildingValidator = $typeElementBuildingValidator;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param int $groupTypeElementId
     * @param TypeElementBuildingModel $typeElement
     * @return TypeElementBuildingModel
     */
    private function handle( $groupTypeElementId, TypeElementBuildingModel $typeElement )
    {

        $groupTypeElement = $this->getGroupTypeElementBuildingDao()->get( $groupTypeElementId );

        if ( $groupTypeElement )
        {
            $typeElement->setGroupId( $groupTypeElement->getId() );
        }
        else
        {
            $typeElement->setGroupId( null );
        }

        return $typeElement;

    }

    /**
     * @param TypeElementBuildingModel $typeElement
     * @return TypeElementBuildingModel
     */
    public function handleNew( $groupTypeElementId, TypeElementBuildingModel $typeElement )
    {

        // Handle Type Element
        $typeElement = $this->handle( $groupTypeElementId, $typeElement );

        // Add Type Element
        $typeElementId = $this->getTypeElementBuildingDao()->add( $typeElement, $typeElement->getGroupId() );

        // Get added Type Element
        $typeElementAdded = $this->getTypeElementBuildingDao()->get( $typeElementId );

        // Return added Type Element
        return $typeElementAdded;

    }

    /**
     * @param TypeElementBuildingModel typeElementEdited   * @return TypeElementBuildingModel
     */
    public function handleEdit( $groupTypeElementId, TypeElementBuildingModel $typeElement )
    {

        // Handle Type Element
        $typeElement = $this->handle( $groupTypeElementId, $typeElement );

        // Edit Type Element
        $this->getTypeElementBuildingDao()->edit( $typeElement->getId(), $typeElement,
                $typeElement->getGroupId() );

        // Get edited Type Element
        $typeElementEdited = $this->getTypeElementBuildingDao()->get( $typeElement->getId() );

        // Return added Type Element
        return $typeElementEdited;

    }

    // /FUNCTIONS


}

?>