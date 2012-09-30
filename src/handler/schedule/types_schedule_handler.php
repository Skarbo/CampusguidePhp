<?php

class TypesScheduleHandler extends Handler
{

    // VARIABLES


    /**
     * @var TypeScheduleDao
     */
    private $typeScheduleDao;

    // /VARIABLES


    // CONSTRUCTOR


    public function __construct( TypeScheduleDao $typeScheduleDao = null )
    {
        if ( $typeScheduleDao )
            $this->setTypeScheduleDao( $typeScheduleDao );
    }

    // /CONSTRUCTOR


    // FUNCTIONS


    // ... GETTERS/SETTERS


    /**
     * @return TypeScheduleDao
     */
    public function getTypeScheduleDao()
    {
        return $this->typeScheduleDao;
    }

    /**
     * @param TypeScheduleDao $typeScheduleDao
     */
    public function setTypeScheduleDao( TypeScheduleDao $typeScheduleDao )
    {
        $this->typeScheduleDao = $typeScheduleDao;
    }

    // ... /GETTERS/SETTERS


    /**
     * @param integer $websiteId
     * @param TypeScheduleListModel $types
     * @param integer $entryId Adds Entry reference if given
     */
    public function handle( $websiteId, TypeScheduleListModel $types, $entryId = null )
    {
        $typesAdded = TypeScheduleListModel::get_( $this->getTypeScheduleDao()->getForeign( array ( $websiteId ) ) );
        for ( $types->rewind(); $types->valid(); $types->next() )
        {
            $type = $types->current();

            $typeDuplicate = $typesAdded->contains( $type );
            if ( $typeDuplicate )
            {
                $type->setId( $typeDuplicate->getId() );
            }
            else
            {
                $type->setId( $this->getTypeScheduleDao()->add( $type, $websiteId ) );
                $typesAdded->add( $type );
            }

            if ( $entryId )
                $this->getTypeScheduleDao()->addEntry( $entryId, $type->getId() );
        }
    }

    // /FUNCTIONS


}

?>