<?php

class WebsiteScheduleModel extends Model implements StandardModel
{

    // VARIABLES

    const TYPE_TIMEEDIT = "timeedit";

    private $id;
    private $url;
    private $type;
    private $parsed;
    private $registered;

    // /VARIABLES


    // CONSTRUCTOR


    // /CONSTRUCTOR


    // FUNCTIONS


    /**
     * @see StandardModel::getForeignId()
     */
    public function getForeignId()
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId( $id )
    {
        $this->id = $id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl( $url )
    {
        $this->url = $url;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType( $type )
    {
        $this->type = $type;
    }

    public function getParsed()
    {
        return $this->parsed;
    }

    public function setParsed( $parsed )
    {
        $this->parsed = $parsed;
    }

    public function getRegistered()
    {
        return $this->registered;
    }

    public function setRegistered( $registered )
    {
        $this->registered = $registered;
    }

    /**
     * @see StandardModel::getLastModified()
     */
    public function getLastModified()
    {
        return max( $this->getParsed(), $this->getRegistered() );
    }

    // ... STATIC


    /**
     * @param WebsiteScheduleModel $get
     * @return WebsiteScheduleModel
     */
    public static function get_( $get )
    {
        return parent::get_( $get );
    }

    // ... /STATIC


    // /FUNCTIONS


}

?>