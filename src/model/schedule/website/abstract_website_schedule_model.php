<?php

abstract class AbstractWebsiteScheduleModel extends Model implements StandardModel
{

    // VARIABLES


    private $websiteId;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return $this->getWebsiteId();
    }

    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    public function setWebsiteId( $websiteId )
    {
        $this->websiteId = $websiteId;
    }
    // /FUNCTIONS


}

?>