<?php

class GroupsTypeElementBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingelementtypegroups";

    /**
     * @var GroupTypeElementBuildingValidator
     */
    private $groupTypeElementBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $db_api, $locale, $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );

        $this->setGroupTypeElementBuildingValidator( new GroupTypeElementBuildingValidator( $this->getLocale() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
 * @return GroupTypeElementBuildingValidator
 */
    public function getGroupTypeElementBuildingValidator()
    {
        return $this->groupTypeElementBuildingValidator;
    }

    /**
 * @param GroupTypeElementBuildingValidator $groupTypeElementBuildingValidator
 */
    public function setGroupTypeElementBuildingValidator( GroupTypeElementBuildingValidator $groupTypeElementBuildingValidator )
    {
        $this->groupTypeElementBuildingValidator = $groupTypeElementBuildingValidator;
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
        return $this->getGroupTypeElementBuildingDao();
    }

    /**
     * @see StandardCampusguideRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return null;
    }

    /**
     * @see StandardCampusguideRestController::getModelPost()
     */
    protected function getModelPost()
    {

        $elementTypeGroup = new GroupTypeElementBuildingModel( $this->getPostObject() );

        // Validate
        $this->getGroupTypeElementBuildingValidator()->doValidate( $elementTypeGroup );

        return $elementTypeGroup;

    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new GroupTypeElementBuildingListModel();
    }

    // ... /GET


    /**
     * Overwrite beforeIsAdd function
     *
     * @see StandardCampusguideRestController::beforeIsAdd()
     */
    protected function beforeIsAdd()
    {
        // Set empty foreign model
        $this->setForeignModel(
                GroupTypeElementBuildingFactoryModel::createGroupTypeElementBuilding( "Empty Group" ) );
    }

    // /FUNCTIONS


}

?>