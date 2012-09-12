<?php

class ElementsBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingelements";

    const COMMAND_GET_BUILDING = "building";

    /**
     * @var ElementBuildingHandler
     */
    private $elementBuildingHandler;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

        $this->setElementBuildingHandler(
                new ElementBuildingHandler( $this->getCampusguideHandler()->getElementBuildingDao(),
                        $this->getCampusguideHandler()->getSectionBuildingDao(),
                        $this->getCampusguideHandler()->getTypeElementBuildingDao(),
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
        return $this->getCampusguideHandler()->getElementBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getCampusguideHandler()->getFloorBuildingDao();
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


    // ... IS


    /**
     * @return boolean True if command is get Building
     */
    protected static function isGetBuildingCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_GET_BUILDING && self::getId();
    }

    // ... /IS


    /**
     * @see StandardRestController::doAddCommand()
     */
    protected function doAddCommand()
    {

        // Get Element post
        $element = $this->getModelPost();

        // Handle new Element
        $elementAdded = $this->getElementBuildingHandler()->handleNewElement(
                $this->getForeignModel()->getId(), $element );

        // Set Element
        $this->setModel( $elementAdded );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementAdded->getForeignId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }

    /**
     * @see StandardRestController::doEditCommand()
     */
    protected function doEditCommand()
    {

        // Get Element post
        $element = $this->getModelPost();

        // Handle edit Element
        $elementEdited = $this->getElementBuildingHandler()->handleEditElement(
                $this->getModel()->getForeignId(), $element );

        // Set Element
        $this->setModel( $elementEdited );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementEdited->getForeignId() ) ) );

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }

    protected function doGetBuildingCommand()
    {

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getBuilding( self::getId() ) );

        // Add to list
        if ( !$this->getModelList()->isEmpty() )
            $this->setModel( $this->getModelList()->get( 0 ) );

            // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    // /FUNCTIONS


    public function request()
    {

        try
        {
            parent::request();
        }
        catch ( BadrequestException $e )
        {
            if ( $e->getCustomCode() != BadrequestException::UNKNOWN_COMMAND )
                throw $e;

            if ( self::isGetBuildingCommand() )
            {
                $this->doGetBuildingCommand();
            }
            else
            {
                throw $e;
            }
        }

    }

}

?>