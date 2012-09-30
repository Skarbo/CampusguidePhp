<?php

abstract class TypeScheduleDbDao extends StandardDbDao implements TypeScheduleDao
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GET


    protected abstract function getFieldCode();

    protected abstract function getFieldName();

    protected abstract function getFieldNameShort();

    protected abstract function getFieldUpdated();

    protected abstract function getTableEntry();

    protected abstract function getFieldEntryId();

    protected abstract function getFieldEntryTypeId();

    protected abstract function getFieldEntryUpdated();

    /**
     * @see StandardDbDao::getInsertUpdateFieldsBinds()
     */
    protected function getInsertUpdateFieldsBinds( StandardModel $model, $foreignId = null, $isInsert = false )
    {
        $fields = array ();
        $binds = array ();
        $model = TypeScheduleModel::get_( $model );

        $fields[ $this->getForeignField() ] = ":websiteId";
        $binds[ "websiteId" ] = $foreignId;

        if ( $model->getCode() )
        {
            $fields[ $this->getFieldCode() ] = ":code";
            $binds[ "code" ] = $model->getCode();
        }
        if ( !is_null( $model->getName() ) )
        {
            $fields[ $this->getFieldName() ] = ":name";
            $binds[ "name" ] = $model->getName();
        }
        if ( !is_null( $model->getNameShort() ) )
        {
            $fields[ $this->getFieldNameShort() ] = ":nameShort";
            $binds[ "nameShort" ] = $model->getNameShort();
        }

        if ( !$isInsert )
        {
            $fields[ $this->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;
        }

        return array ( $fields, $binds );
    }

    /**
     * @see StandardDbDao::getInsertQuery()
     */
    protected function getInsertQuery( StandardModel $model, $foreignId )
    {
        $fields = array ();
        $binds = array ();
        $model = TypeScheduleModel::get_( $model );

        $insertQuery = parent::getInsertQuery( $model, $foreignId );

        if ( $model->getCode() )
        {
            $fields[ $this->getFieldCode() ] = ":code";
            $binds[ "code" ] = $model->getCode();
        }
        if ( $model->getName() )
        {
            $fields[ $this->getFieldName() ] = ":name";
            $binds[ "name" ] = $model->getName();
        }
        if ( $model->getNameShort() )
        {
            $fields[ $this->getFieldNameShort() ] = ":nameShort";
            $binds[ "nameShort" ] = $model->getNameShort();
        }

        $fields[ $this->getFieldUpdated() ] = SB::$CURRENT_TIMESTAMP;

        $insertQuery->getQuery()->setDuplicate( $fields );

        $insertQuery->addBind( $binds );

        return $insertQuery;
    }

    // ... /GET


    /**
     * @see TypeScheduleDao::addEntry()
     * @throws DbException
     */
    public function addEntry( $entryId, $typeId )
    {
        $insertQuery = new InsertQueryDbCore();

        $insertBuild = new InsertSqlbuilderDbCore();
        $insertBuild->setInto( $this->getTableEntry() );
        $insertBuild->setSetValues(
                array ( $this->getFieldEntryId() => ":entryId", $this->getFieldEntryTypeId() => ":typeId" ) );
        $insertBuild->setDuplicate(
                array ( $this->getFieldEntryUpdated() => SB::$CURRENT_TIMESTAMP ) );
        $insertQuery->setQuery( $insertBuild );

        $insertQuery->addBind( array ( "entryId" => $entryId, "typeId" => $typeId ) );

        $result = $this->getDbApi()->query( $insertQuery );

        return $result->isExecute();
    }

    /**
     * @see TypeScheduleDao::getDuplicate()
     */
    public function getDuplicate( $websiteId, TypeScheduleModel $type )
    {
        $selectQuery = $this->getSelectQuery();

        $searchCode = SB::and_( SB::isnotnull( $this->getFieldCode() ), SB::equ( $this->getFieldCode(), ":code" ) );
        $searchNameShort = SB::and_( SB::isnotnull( $this->getFieldNameShort() ),
                SB::notequ( $this->getFieldNameShort(), SB::quote( "" ) ),
                SB::like( $this->getFieldNameShort(), ":nameShort" ) );
        $selectQuery->getQuery()->addWhere( SB::or_( $searchCode, $searchNameShort ) );
        $selectQuery->getQuery()->addWhere( SB::equ( $this->getForeignField(), ":websiteId" ) );

        $selectQuery->addBind(
                array ( "nameShort" => preg_replace( self::$REGEX_WILDCARD, "%", $type->getNameShort() ),
                        "code" => $type->getCode(), "websiteId" => $websiteId ) );

        $result = $this->getDbApi()->query( $selectQuery );

        return count( $result->getRows() ) > 0 ? $this->createModel( $result->getRow( 0 ) ) : null;
    }

    // /FUNCTIONS


}

?>