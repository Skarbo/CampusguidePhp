<?php

interface QueueAdminCmsInterfaceView extends InterfaceView
{

    /**
     * @return QueueListModel
     */
    public function getQueues();

    /**
     * @return WebsiteScheduleListModel
     */
    public function getWebsites();

    /**
     * @return FacilityListModel
     */
    public function getFacilities();

}

?>