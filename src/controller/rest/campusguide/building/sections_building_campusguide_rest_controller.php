<?php

class SectionsBuildingCampusguideRestController extends StandardCampusguideRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingsections";

    /**
     * @var SectionBuildingValidator
     */
    private $sectionBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $db_api, $locale, $view, $mode )
    {
        parent::__construct( $db_api, $locale, $view, $mode );

        $this->setSectionBuildingValidator( new SectionBuildingValidator( $this->getLocale() ) );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return SectionBuildingValidator
     */
    public function getSectionBuildingValidator()
    {
        return $this->sectionBuildingValidator;
    }

    /**
     * @param SectionBuildingValidator $sectionBuildingValidator
     */
    public function setSectionBuildingValidator( SectionBuildingValidator $sectionBuildingValidator )
    {
        $this->sectionBuildingValidator = $sectionBuildingValidator;
    }

    // ... /GETTERS/SETTERS


    /**
     * @see StandardCampusguideRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getSectionBuildingDao();
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

        // Retrieve Section from POST
        $section = new SectionBuildingModel( $this->getPostObject() );

        // Validate Section
        $this->getSectionBuildingValidator()->doValidate( $section, "Section is not validated" );

        return $section;

    }

    /**
     * @see StandardCampusguideRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new SectionBuildingListModel();
    }

    // /FUNCTIONS


}

?>