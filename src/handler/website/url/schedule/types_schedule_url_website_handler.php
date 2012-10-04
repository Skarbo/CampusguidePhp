<?php

interface TypesScheduleUrlWebsiteHandler
{

    /**
     * @param string $url
     * @param string $type
     * @param integer $page [>0]
     */
    public function getTypesUrl( $url, $type, $page );

}

?>