<?php

class QueueListModel extends IteratorCore
{

    // VARIABLES


    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @return array Array( website id, ... )
     */
    public function getWebsiteIds()
    {
        $websiteIds = array ();
        for ( $this->rewind(); $this->valid(); $this->next() )
        {
            $queue = $this->current();
            $websiteIds[] = $queue->getWebsiteId();
        }
        return array_unique( array_filter( $websiteIds ) );
    }

    /**
     * @see IteratorCore::get()
     * @return QueueModel
     */
    public function get( $i )
    {
        return parent::get( $i );
    }

    /**
     * @see IteratorCore::add()
     * @return QueueModel
     */
    public function add( $add )
    {
        parent::add( $add );
    }

    /**
     * @see IteratorCore::current()
     * @return QueueModel
     */
    public function current()
    {
        return parent::current();
    }

    // ... STATIC


    /**
     * @param QueueListModel $get
     * @return QueueListModel
     */
    public static function get_( $get )
    {
        return $get;
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>