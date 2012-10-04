<?php

class TypesTimeeditScheduleUrlWebsiteHandlerTest extends ClassCore implements TypesScheduleUrlWebsiteHandler
{

    // VARIABLES

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see TypesScheduleUrlWebsiteHandler::getTypesUrl()
     */
    public function getTypesUrl( $url, $type, $page )
    {
        return sprintf( $url, $page );
    }

    // /FUNCTIONS


}

?>