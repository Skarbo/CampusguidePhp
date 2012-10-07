<?php

class SectionsBuildingRestController extends StandardRestController
{

    // VARIABLES


    public static $CONTROLLER_NAME = "buildingsections";

    /**
     * @var SectionBuildingValidator
     */
    private $sectionBuildingValidator;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( $api, $view )
    {
        parent::__construct( $api, $view );

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
     * @see StandardRestController::getStandardDao()
     */
    protected function getStandardDao()
    {
        return $this->getDaoContainer()->getSectionBuildingDao();
    }

    /**
     * @see StandardRestController::getForeignStandardDao()
     */
    protected function getForeignStandardDao()
    {
        return $this->getDaoContainer()->getBuildingDao();
    }

    /**
     * @see StandardRestController::getModelPost()
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
     * @see StandardRestController::getModelListInit()
     */
    protected function getModelListInit()
    {
        return new SectionBuildingListModel();
    }

    // /FUNCTIONS


}

?>