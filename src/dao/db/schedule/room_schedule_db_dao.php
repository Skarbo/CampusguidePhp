<?php

class RoomScheduleDbDao extends TypeScheduleDbDao implements RoomScheduleDao
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
        return Resource::db()->roomSchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->roomSchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->roomSchedule()->getFieldWebsiteId();
    }

    /**
     * @see TypeScheduleDbDao::getTableEntry()
     */
    protected function getTableEntry()
    {
        return Resource::db()->roomSchedule()->getTableEntry();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryId()
     */
    protected function getFieldEntryId()
    {
        return Resource::db()->roomSchedule()->getFieldEntryEntryId();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryTypeId()
     */
    protected function getFieldEntryTypeId()
    {
        return Resource::db()->roomSchedule()->getFieldEntryRoomId();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {
        list ( $fields, $binds ) = parent::getInsertUpdateFieldsBinds( $model, $foreignId, $isInsert );
        $model = RoomScheduleModel::get_( $model );

        if ( $model->getElementId() )
        {
            $fields[ Resource::db()->roomSchedule()->getFieldElementId() ] = ":elementId";
            $binds[ "elementId" ] = $model->getElementId();
        }

        return array ( $fields, $binds );
    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new RoomScheduleListModel();
    }

    /**
     * @see TypeScheduleDbDao::getFieldCode()
     */
    protected function getFieldCode()
    {
        return Resource::db()->roomSchedule()->getFieldCode();
    }

    /**
     * @see TypeScheduleDbDao::getFieldName()
     */
    protected function getFieldName()
    {
        return Resource::db()->roomSchedule()->getFieldName();
    }

    /**
     * @see TypeScheduleDbDao::getFieldNameShort()
     */
    protected function getFieldNameShort()
    {
        return Resource::db()->roomSchedule()->getFieldNameShort();
    }

    /**
     * @see TypeScheduleDbDao::getFieldUpdated()
     */
    protected function getFieldUpdated()
    {
        return Resource::db()->roomSchedule()->getFieldUpdated();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryUpdated()
     */
    protected function getFieldEntryUpdated()
    {
        return Resource::db()->roomSchedule()->getFieldEntryUpdated();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = RoomScheduleFactoryModel::createRoomSchedule(
                Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldElementId() ),
                Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldCode() ),
                Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldNameShort() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setWebsiteId(
                intval( Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldWebsiteId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp( Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->roomSchedule()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>