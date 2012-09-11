<?php

class TypesElementBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingelementtypes";

    /**
     * @var TypeElementBuildingHandler
     */
    private $typeElementBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

        $this->setTypeElementBuildingHandler(
                new TypeElementBuildingHandler( $this->getCampusguideHandler()->getTypeElementBuildingDao(),
                        $this->getCampusguideHandler()->getGroupTypeElementBuildingDao(), new TypeElementBuildingValidator( $this->getLocale() ) ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return TypeElementBuildingHandler
     */
    public function getTypeElementBuildingHandler()
    {
        return $this->typeElementBuildingHandler;
    }

    /**
     * @param TypeElementBuildingHandler $typeElementBuildingHandler
     */
    public function setTypeElementBuildingHandler( TypeElementBuildingHandler $typeElementBuildingHandler )
    {
        $this->typeElementBuildingHandler = $typeElementBuildingHandler;
    }

    // ... /GETTERS/SETTERS


    // ... GET


    /**
     * @see Controller::getLastModified()
     */
    public function getLastModified()
    {
        return max( filemtime( __FILE__ ), parent::getLastModified() );
    }

    /**
     * @see StandardCampusguideRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getCampusguideHandler()->getTypeElementBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getCampusguideHandler()->getGroupTypeElementBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
     */
    protected function getModelPost()
    {

        $elementType = new TypeElementBuildingModel( $this->getPostObject() );

        return $elementType;

    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new TypeElementBuildingListModel();
    }

    // ... /GET

    /**
     * @see StandardCampusguideRestController::doAddCommand()
     */
    protected function doAddCommand()
    {

        // Get Element Type post
        $elementType = $this->getModelPost();

        // Handle new Element Type
        $elementTypeAdded = $this->getTypeElementBuildingHandler()->handleNew(
                $this->getForeignModel()->getId(), $elementType );

        // Set Element Type
        $this->setModel( $elementTypeAdded );

        // Set all Element Types
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementTypeAdded->getGroupId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * @see StandardCampusguideRestController::doEditCommand()
     */
    protected function doEditCommand()
    {

        // Get Element post
        $elementType = $this->getModelPost();

        // Handle edit Element
        $elementTypeEdited = $this->getTypeElementBuildingHandler()->handleEdit(
                $this->getModel()->getForeignId(), $elementType );

        // Set Element
        $this->setModel( $elementTypeEdited );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementTypeEdited->getGroupId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }
    // /FUNCTIONS


}

?>