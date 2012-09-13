<?php

class ElementsBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingelements";

    const COMMAND_GET_BUILDING = "building";
    const COMMAND_DELETE = "delete";

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

    /**
     * @return boolean True if command is get Building
     */
    protected static function isDeleteCommand()
    {
        return self::isGet() && self::getURI( self::URI_COMMAND ) == self::COMMAND_DELETE && self::getId();
    }

    /**
     * @see StandardRestController::isTouchOnManipulate()
     */
    protected function isTouchOnManipulate()
    {
        return true;
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

        // Touch foreign object
        $this->doTouchForeign();

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
        $elementEdited = $this->getElementBuildingHandler()->handleEditElement( $this->getModel()->getId(),
                $element, $this->getModel()->getForeignId() );

        // Set Element
        $this->setModel( $elementEdited );

        // Set all Elements
        $this->setModelList( $this->getStandardDao()->getForeign( array ( $elementEdited->getForeignId() ) ) );

        // Touch foreign object
        $this->doTouchForeign();

        // Set status code
        $this->setStatusCode( self::STATUS_CREATED );

    }

    protected function doGetBuildingCommand()
    {

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getBuilding( self::getId() ) );

        // Set Model
        if ( !$this->getModelList()->isEmpty() )
            $this->setModel( $this->getModelList()->get( 0 ) );

            // Set status scode
        $this->setStatusCode( self::STATUS_OK );

    }

    protected function doDeleteCommand()
    {

        // Delete model
        $this->getStandardDao()->delete( self::getId() );

        // Set Model
        $this->setModel( $this->getStandardDao()->get( self::getId() ) );

        // Set Model list
        $this->setModelList( $this->getStandardDao()->getForeign( $this->getModel()->getForeignId() ) );

        // Set status scode
        $this->setStatusCode( self::STATUS_CREATED );

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
            else if ( self::isDeleteCommand() )
            {
                $this->doDeleteCommand();
            }
            else
            {
                throw $e;
            }
        }

    }

}

?>