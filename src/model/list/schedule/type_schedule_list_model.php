<?php

abstract class TypeScheduleListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return array Array( code, ... )
     */
    public function getCodes()
    {
        $codes = array ();
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $type = $this->current();
            $codes[] = $type->getCode();
        }
        return $codes;
    }

    /**
     * @see StandardListModel::current()
     * @return TypeScheduleModel
     */
    public function current()
    {
        return parent::current();
    }

    /**
     * @param TypeScheduleModel $type
     * @return TypeScheduleModel Type it contains, null if not
     */
    public function contains( TypeScheduleModel $typeContain )
    {
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $type = $this->current();
            if ( $type->isEqual( $typeContain ) )
                return $type;
        }
        return null;
    }

    /**
     * @param TypeScheduleListModel $types
     * @return boolean true if euqal
     */
    public function isEqual( TypeScheduleListModel $types )
    {
        if ( $types->size() != $this->size() )
            return false;
        if ( $this->isEmpty() )
            return true;

        $this->sort();
        $types->sort();
        for ( $this->rewind(), $i = 0; $this->valid(); $this->next(), $i++ )
        {
            $type = $this->current();
            if ( !$type->isEqual( $types->get( $i ) ) )
                return false;
        }
        return true;
    }

    /**
     * Sorts types by name, then short name
     *
     * @return void
     */
    public function sort()
    {
        usort( $this->array,
                function ( TypeScheduleModel $left, TypeScheduleModel $right )
                {
                    $cmp = strcasecmp( $left->getName(), $right->getName() );
                    return $cmp == 0 ? strcasecmp( $left->getNameShort(), $right->getNameShort() ) : $cmp;
                } );
    }

    /**
     * @param TypeScheduleListModel $get
     * @return TypeScheduleListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // /FUNCTIONS


}

?>