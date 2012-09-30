<?php

class ProgramScheduleDbDao extends TypeScheduleDbDao implements ProgramScheduleDao
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
        return Resource::db()->programSchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->programSchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->programSchedule()->getFieldWebsiteId();
    }

    /**
     * @see TypeScheduleDbDao::getTableEntry()
     */
    protected function getTableEntry()
    {
        return Resource::db()->programSchedule()->getTableEntry();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryId()
     */
    protected function getFieldEntryId()
    {
        return Resource::db()->programSchedule()->getFieldEntryEntryId();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryTypeId()
     */
    protected function getFieldEntryTypeId()
    {
        return Resource::db()->programSchedule()->getFieldEntryProgramId();
    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new ProgramScheduleListModel();
    }

    /**
     * @see TypeScheduleDbDao::getFieldCode()
     */
    protected function getFieldCode()
    {
        return Resource::db()->programSchedule()->getFieldCode();
    }

    /**
     * @see TypeScheduleDbDao::getFieldName()
     */
    protected function getFieldName()
    {
        return Resource::db()->programSchedule()->getFieldName();
    }

    /**
     * @see TypeScheduleDbDao::getFieldNameShort()
     */
    protected function getFieldNameShort()
    {
        return Resource::db()->programSchedule()->getFieldNameShort();
    }

    /**
     * @see TypeScheduleDbDao::getFieldUpdated()
     */
    protected function getFieldUpdated()
    {
        return Resource::db()->programSchedule()->getFieldUpdated();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryUpdated()
     */
    protected function getFieldEntryUpdated()
    {
        return Resource::db()->programSchedule()->getFieldEntryUpdated();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = ProgramScheduleFactoryModel::createProgramSchedule(
                Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldCode() ),
                Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldNameShort() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setWebsiteId(
                intval(
                        Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldWebsiteId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->programSchedule()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>