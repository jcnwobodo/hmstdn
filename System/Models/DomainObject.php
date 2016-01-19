<?php
namespace System\Models;

abstract class DomainObject
{
    private $id = -1;

    public function __construct( $id=null )
    {
        if(is_null($id))
        {
            $this->markNew();
        }
        else
        {
            $this->id = $id;
        }
    }

    public function setId($id)
    {
        $this->id = $id;
        $this->markDirty();
        return $this;
    }
    public function getId()
    {
        return $this->id;
    }

    public static function getCollection($type)
    {
        return DomainObjectHelper::getCollection($type);
    }
    public function collection()
    {
        return self::getCollection( get_class( $this ) );
    }

    public static function getMapper($class_name)
    {
        return DomainObjectHelper::getMapper( $class_name );
    }
    public function mapper()
    {
        return self::getMapper( get_class( $this ) );
    }

    public function markClean()
    {
        DomainObjectWatcher::addClean($this);
    }

    public function markNew()
    {
        DomainObjectWatcher::addNew($this);
    }

    public function markDirty()
    {
        DomainObjectWatcher::addDirty($this);
    }

    public function markDelete()
    {
        DomainObjectWatcher::addDelete($this);
    }
}