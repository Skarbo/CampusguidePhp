<?php

class GroupScheduleDbDao extends TypeScheduleDbDao implements GroupScheduleDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    /**
     * @see StandardDbDao::getTable()
     */
    protected function getTable()
    {
        return Resource::db()->groupSchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->groupSchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->groupSchedule()->getFieldWebsiteId();
    }

    /**
     * @see TypeScheduleDbDao::getTableEntry()
     */
    protected function getTableEntry()
    {
        return Resource::db()->groupSchedule()->getTableEntry();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryId()
     */
    protected function getFieldEntryId()
    {
        return Resource::db()->groupSchedule()->getFieldEntryEntryId();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryTypeId()
     */
    protected function getFieldEntryTypeId()
    {
        return Resource::db()->groupSchedule()->getFieldEntryGroupId();
    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new GroupScheduleListModel();
    }

    /**
     * @see TypeScheduleDbDao::getFieldCode()
     */
    protected function getFieldCode()
    {
        return Resource::db()->groupSchedule()->getFieldCode();
    }

    /**
     * @see TypeScheduleDbDao::getFieldName()
     */
    protected function getFieldName()
    {
        return Resource::db()->groupSchedule()->getFieldName();
    }

    /**
     * @see TypeScheduleDbDao::getFieldNameShort()
     */
    protected function getFieldNameShort()
    {
        return Resource::db()->groupSchedule()->getFieldNameShort();
    }

    /**
     * @see TypeScheduleDbDao::getFieldUpdated()
     */
    protected function getFieldUpdated()
    {
        return Resource::db()->groupSchedule()->getFieldUpdated();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryUpdated()
     */
    protected function getFieldEntryUpdated()
    {
        return Resource::db()->groupSchedule()->getFieldEntryUpdated();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = GroupScheduleFactoryModel::createGroupSchedule(
                Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldId() ),
                Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldCode() ),
                Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldNameShort() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setWebsiteId(
                intval( Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldWebsiteId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->groupSchedule()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>