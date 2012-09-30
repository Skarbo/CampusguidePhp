<?php

class EntryScheduleListModel extends StandardListModel
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * Adds Entry as occurence if it is equal to another Entry
     *
     * @param EntryScheduleModel $entry
     */
    public function addEntry( EntryScheduleModel $entryAdd )
    {
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $entry = $this->current();
            if ( $entry->isEqual( $entryAdd ) )
            {
                $entry->merge( $entryAdd );
                return;
            }
        }
        $this->add( $entryAdd );
    }

    /**
     * @see IteratorCore::get()
     * @return EntryScheduleModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return EntryScheduleModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return EntryScheduleModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param EntryScheduleListModel $get
     * @return EntryScheduleListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>