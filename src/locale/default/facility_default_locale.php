<?php

class FacilityDefaultLocale extends Locale
{

    // VARIABLES


    protected $deletingFacility = "Deleting %d %s";
    protected $deletingFacilitySure = "Are you sure you want to delete %d %s?";

    protected $successDelete = "Successfully deleted Facilities";
    protected $successAdded = "Successfully added Facility";
    protected $successEdited = "Successfully edited Facility";

    private $facility = "Facility";
    private $facilities = "Facilities";

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // /FUNCTIONS


    public function getFacility()
    {
        return $this->facility;
    }

    public function getFacilities()
    {
        return $this->facilities;
    }

    public function getDeletingFacility( $facilitiesSize )
    {
        return ucwords(
                sprintf( $this->deletingFacility, $facilitiesSize,
                        Locale::instance()->quantity( $facilitiesSize, $this->getFacility(), $this->getFacilities() ) ) );
    }

    public function getDeletingFacilitySure( $facilitiesSize )
    {
        return sprintf( $this->deletingFacilitySure, $facilitiesSize,
                Locale::instance()->quantity( $facilitiesSize, $this->getFacility(), $this->getFacilities() ) );
    }

    public function getSuccess( $success )
    {
        switch ( $success )
        {
            case FacilitiesCmsCampusguideMainController::SUCCESS_FACILITY_DELETED :
                return $this->successDelete;
                break;
            case FacilitiesCmsCampusguideMainController::SUCCESS_FACILITY_ADDED :
                return $this->successAdded;
                break;
            case FacilitiesCmsCampusguideMainController::SUCCESS_FACILITY_EDITED :
                return $this->successEdited;
                break;
        }
    }

}

?>