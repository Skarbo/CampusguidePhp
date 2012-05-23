<?php

class ElementsBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingelements";

    /**
     * @var ElementBuildingHandler
     */
    private $elementBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $db_api, $locale, $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );

        $this->setElementBuildingHandler(
                new ElementBuildingHandler( $this->getElementBuildingDao(), $this->getSectionBuildingDao(),
                        $this->getTypeElementBuildingDao(), $this->getFloorBuildingDao(),
                        new ElementBuildingValidator( $this->getLocale() ) ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return ElementBuildingHandler
     */
    public function getElementBuildingHandler()
    {
        return $this->elementBuildingHandler;
    }

    /**
     * @param ElementBuildingHandler $elementBuildingHandler
     */
    public function setElementBuildingHandler( ElementBuildingHandler $elementBuildingHandler )
    {
        $this->elementBuildingHandler = $elementBuildingHandler;
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
        return $this->getElementBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
     */
    protected function getModelPost()
    {

        $element = new ElementBuildingModel( $this->getPostObject() );

        return $element;

    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new ElementBuildingListModel();
    }

    // ... /GET


    protected function doAddCommand()
    {

        // Get Element post
        $element = $this->getModelPost();

        // Handle new Element
        $elementAdded = $this->getElementBuildingHandler()->handleNewElement( $this->getForeignModel()->getId(), $element );

        // Set Element
        $this->setModel( $elementAdded );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementAdded->getBuildingId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * Do edit command
     */
    protected function doEditCommand()
    {

        // Get Element post
        $element = $this->getModelPost();

        // Handle edit Element
        $elementEdited = $this->getElementBuildingHandler()->handleEditElement( $this->getModel()->getForeignId(),
                $element );

        // Set Element
        $this->setModel( $elementEdited );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementEdited->getBuildingId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }
    // /FUNCTIONS


}

?>