<?php

class WebsiteScheduleFactoryModel extends ClassCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return WebsiteScheduleModel
     */
    public static function createWebsiteSchedule( $url, $type )
    {

        // Initiate model
        $websiteSchedule = new WebsiteScheduleModel();

        $websiteSchedule->setUrl( $url );
        $websiteSchedule->setType( $type );

        // Return model
        return $websiteSchedule;

    }

    // /FUNCTIONS


}

?>