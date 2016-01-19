<?php
namespace System\Models\Mappers;

use \Application\Config\ApplicationRegistry;
use \Application\Models\DomainObject;
use \System\Models\DomainObjectWatcher;

abstract class Mapper
{
    protected static $PDO;

    public function __construct()
    {
        if ( ! isset(self::$PDO) )
        {
            $dsn = ApplicationRegistry::getDSN();
            $user = ApplicationRegistry::getDbUser();
            $password = ApplicationRegistry::getDbUserPassword();

            if ( is_null( $dsn ) )
            {
                throw new \Exception( "No DSN" );
            }
            self::$PDO = new \PDO($dsn, $user, $password);
            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    public function find( $id )
    {
        return $this->findHelper($id, $this->selectStmt());
    }

    public function findAll( )
    {
        $this->selectAllStmt()->execute( array() );
        return $this->getCollection($this->selectAllStmt()->fetchAll( \PDO::FETCH_ASSOC ) );
    }

    public function createObject( $array )
    {
        $old = $this->getFromMap( $array['id']);
        if ( is_object($old) ) { return $old; }
        //construct object
        $obj = $this->doCreateObject( $array );
        //keep record of object
        $this->addToMap($obj);
        $obj->markClean();

        return $obj;
    }

    public function insert(DomainObject $domainObject)
    {
        $this->doInsert( $domainObject );
        $this->addToMap( $domainObject );
        $domainObject->markClean();
    }

    public function update(DomainObject $domainObject)
    {
        $this->doUpdate( $domainObject );
        $domainObject->markClean();
    }

    public function delete(DomainObject $domainObject)
    {
        $this->doDelete( $domainObject );
        $domainObject->markClean();
    }

    protected function findHelper($key, \PDOStatement $statement, $compulsory_index = 'id')
    {
        $old = $this->getFromMap( $key );
        if ($old)
        {
            return $old;
        }
        //do db stuff
        $statement->execute( ( is_array($key) ? $key : array($key) ) );
        $array = $statement->fetch();
        $statement->closeCursor();
        if( ! is_array($array) )
        {
            return null;
        }
        if ( ! isset($array[$compulsory_index]) )
        {
            return null;
        }
        return $this->createObject($array);
    }

    protected function getFromMap( $id )
    {
        return DomainObjectWatcher::exists( $this->targetClass(), $id );
    }

    protected function addToMap(DomainObject $obj )
    {
        DomainObjectWatcher::add( $obj );
    }

    protected abstract function getCollection( array $raw );
    protected abstract function targetClass();
    protected abstract function doCreateObject( array $array );
    protected abstract function doInsert(DomainObject $object );
    protected abstract function doUpdate(DomainObject $object );
    protected abstract function doDelete(DomainObject $object );
    protected abstract function selectStmt();
    protected abstract function selectAllStmt();
}