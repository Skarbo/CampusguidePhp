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


    /**
     * @see RoomScheduleDao::mergeElements()
     */
    public function mergeElements()
    {
        /*
        UPDATE schedule_room SET schedule_room.element_id = (
                SELECT DISTINCT building_element.element_id
                FROM schedule_website

                LEFT JOIN schedule_website_building ON
                schedule_website.website_id = schedule_website_building.website_id

                LEFT JOIN building ON
                schedule_website_building.building_id = building.building_id

                LEFT JOIN building_floor ON
                building.building_id = building_floor.building_id

                LEFT JOIN building_element ON
                building_floor.floor_id = building_element.floor_id AND building_element.element_type_group = 'room'

                WHERE
                schedule_room.website_id = schedule_website.website_id AND
                schedule_room.room_name_short LIKE building_element.element_name)
                */

        $updateQuery = new UpdateQueryDbCore();

        // Select Element builder
        $selectElementBuilder = new SelectSqlbuilderDbCore();
        $selectElementBuilder->setExpression(
                Core::cc( " ", SB::$DISTINCT, Resource::db()->roomSchedule()->getFieldElementId() ) );
        $selectElementBuilder->setFrom( Resource::db()->websiteSchedule()->getTable() );
        $selectElementBuilder->addJoin(
                SB::join( Resource::db()->websiteSchedule()->getTableBuilding(),
                        SB::equ(
                                SB::pun( Resource::db()->websiteSchedule()->getTable(),
                                        Resource::db()->websiteSchedule()->getFieldId() ),
                                SB::pun( Resource::db()->websiteSchedule()->getTableBuilding(),
                                        Resource::db()->websiteSchedule()->getFieldBuildingWebsiteId() ) ) ) );
        $selectElementBuilder->addJoin(
                SB::join( Resource::db()->building()->getTable(),
                        SB::equ(
                                SB::pun( Resource::db()->websiteSchedule()->getTableBuilding(),
                                        Resource::db()->websiteSchedule()->getFieldBuildingBuildingId() ),
                                SB::pun( Resource::db()->building()->getTable(),
                                        Resource::db()->building()->getFieldId() ) ) ) );
        $selectElementBuilder->addJoin(
                SB::join( Resource::db()->floorBuilding()->getTable(),
                        SB::equ(
                                SB::pun( Resource::db()->building()->getTable(),
                                        Resource::db()->building()->getFieldId() ),
                                SB::pun( Resource::db()->floorBuilding()->getTable(),
                                        Resource::db()->floorBuilding()->getFieldBuildingId() ) ) ) );
        $selectElementBuilder->addJoin(
                SB::join( Resource::db()->elementBuilding()->getTable(),
                        SB::and_(
                                SB::equ(
                                        SB::pun( Resource::db()->floorBuilding()->getTable(),
                                                Resource::db()->floorBuilding()->getFieldId() ),
                                        SB::pun( Resource::db()->elementBuilding()->getTable(),
                                                Resource::db()->elementBuilding()->getFieldFloorId() ) ),
                                SB::equ(
                                        SB::pun( Resource::db()->elementBuilding()->getTable(),
                                                Resource::db()->elementBuilding()->getFieldTypeGroup() ), ":typeGroup" ) ) ) );
        $selectElementBuilder->setWhere(
                SB::and_(
                        SB::equ(
                                SB::pun( Resource::db()->roomSchedule()->getTable(),
                                        Resource::db()->roomSchedule()->getFieldWebsiteId() ),
                                SB::pun( Resource::db()->websiteSchedule()->getTable(),
                                        Resource::db()->websiteSchedule()->getFieldId() ) ),
                        SB::like(
                                SB::pun( Resource::db()->roomSchedule()->getTable(),
                                        Resource::db()->roomSchedule()->getFieldNameShort() ),
                                SB::pun( Resource::db()->elementBuilding()->getTable(),
                                        Resource::db()->elementBuilding()->getFieldName() ) ) ) );

        $updateBuilder = new UpdateSqlbuilderDbCore();
        $updateBuilder->setTable( Resource::db()->roomSchedule()->getTable() );
        $updateBuilder->setSet(
                array (
                        Resource::db()->roomSchedule()->getFieldElementId() => SB::par( $selectElementBuilder->build() ) ) );
        $updateQuery->setQuery( $updateBuilder );

        $updateQuery->addBind( array ( "typeGroup" => ElementBuildingModel::TYPE_GROUP_ROOM ) );

        $result = $this->getDbApi()->query( $updateQuery );

        return $result->getAffectedRows();
    }

    // /FUNCTIONS


}

?>