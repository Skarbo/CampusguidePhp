<?php

interface EntriesScheduleUrlWebsiteHandler
{

    /**
     * @param string $url
     * @param TypeScheduleListModel $types
     * @param integer $startWeek Unixtime
     * @param integer $endWeek Unixtime
     */
    public function getEntriesUrl( $url, TypeScheduleListModel $types, $startWeek, $endWeek );

}

?>