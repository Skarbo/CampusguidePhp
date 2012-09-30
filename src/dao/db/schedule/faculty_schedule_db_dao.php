<?php

class FacultyScheduleDbDao extends TypeScheduleDbDao implements FacultyScheduleDao
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
        return Resource::db()->facultySchedule()->getTable();
    }

    /**
     * @see StandardDbDao::getPrimaryField()
     */
    protected function getPrimaryField()
    {
        return Resource::db()->facultySchedule()->getFieldId();
    }

    /**
     * @see StandardDbDao::getForeignField()
     */
    protected function getForeignField()
    {
        return Resource::db()->facultySchedule()->getFieldWebsiteId();
    }

    /**
     * @see TypeScheduleDbDao::getTableEntry()
     */
    protected function getTableEntry()
    {
        return Resource::db()->facultySchedule()->getTableEntry();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryId()
     */
    protected function getFieldEntryId()
    {
        return Resource::db()->facultySchedule()->getFieldEntryEntryId();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryTypeId()
     */
    protected function getFieldEntryTypeId()
    {
        return Resource::db()->facultySchedule()->getFieldEntryFacultyId();
    }

    /**
     * @see TypeScheduleDbDao::getFieldEntryUpdated()
     */
    protected function getFieldEntryUpdated()
    {
        return Resource::db()->facultySchedule()->getFieldEntryUpdated();
    }

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {
        list ( $fields, $binds ) = parent::getInsertUpdateFieldsBinds( $model, $foreignId, $isInsert );
        $model = FacultyScheduleModel::get_( $model );

        if ( $model->getRoomId() )
        {
            $fields[ Resource::db()->facultySchedule()->getFieldRoomId() ] = ":roomId";
            $binds[ "roomId" ] = $model->getRoomId();
        }
        if ( !is_null( $model->getType() ) )
        {
            $fields[ Resource::db()->facultySchedule()->getFieldType() ] = ":type";
            $binds[ "type" ] = $model->getType();
        }
        if ( !is_null( $model->getPhone() ) )
        {
            $fields[ Resource::db()->facultySchedule()->getFieldPhone() ] = ":phone";
            $binds[ "phone" ] = $model->getPhone();
        }
        if ( !is_null( $model->getEmail() ) )
        {
            $fields[ Resource::db()->facultySchedule()->getFieldEmail() ] = ":email";
            $binds[ "email" ] = $model->getEmail();
        }

        return array ( $fields, $binds );
    }

    /**
     * @see StandardDbDao::getInitiatedList()
     */
    protected function getInitiatedList()
    {
        return new FacultyScheduleListModel();
    }

    /**
     * @see TypeScheduleDbDao::getFieldCode()
     */
    protected function getFieldCode()
    {
        return Resource::db()->facultySchedule()->getFieldCode();
    }

    /**
     * @see TypeScheduleDbDao::getFieldName()
     */
    protected function getFieldName()
    {
        return Resource::db()->facultySchedule()->getFieldName();
    }

    /**
     * @see TypeScheduleDbDao::getFieldNameShort()
     */
    protected function getFieldNameShort()
    {
        return Resource::db()->facultySchedule()->getFieldNameShort();
    }

    /**
     * @see TypeScheduleDbDao::getFieldUpdated()
     */
    protected function getFieldUpdated()
    {
        return Resource::db()->facultySchedule()->getFieldUpdated();
    }

    // ... /GET


    // ... CREATE


    /**
     * @see StandardDbDao::createModel()
     */
    protected function createModel( array $modelArray )
    {

        $model = FacultyScheduleFactoryModel::createFacultySchedule(
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldCode() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldName() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldNameShort() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldRoomId() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldType() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldPhone() ),
                Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldEmail() ) );

        $model->setId( intval( Core::arrayAt( $modelArray, $this->getPrimaryField() ) ) );
        $model->setWebsiteId(
                intval( Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldWebsiteId() ) ) );
        $model->setUpdated(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldUpdated() ) ) );
        $model->setRegistered(
                Core::parseTimestamp(
                        Core::arrayAt( $modelArray, Resource::db()->facultySchedule()->getFieldRegistered() ) ) );

        return $model;

    }

    // ... /CREATE


    // /FUNCTIONS


}

?>