<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:28 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\UserCollection;

class UserMapper extends Mapper
{
    private $target_class;

    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_users");
        $this->selectByUsernameStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE username=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_users set username=?,password=?,user_type=?,status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_users (username,password,user_type,status)VALUES(?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_users WHERE id=?");

        $this->selectAllByUserTypeStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE user_type=?;");
        $this->selectTypeByStatusStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE user_type=? AND status=?;");
        $this->selectRandomByUserTypeStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE user_type=:user_type AND status=:user_status ORDER BY RAND() LIMIT :num");
    }

    public function findByUsername($username)
    {
        return $this->findHelper($username, $this->selectByUsernameStmt, 'username');
    }

    public function findByUserType($user_type)
    {
        $this->selectAllByUserTypeStmt->execute( array($user_type) );
        $raw_data = $this->selectAllByUserTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findTypeByStatus($type, $status)
    {
        $this->selectTypeByStatusStmt->execute( array($type, $status) );
        $raw_data = $this->selectTypeByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findRandomByUserType($user_type, $limit=1, $status=1)
    {
        $this->selectRandomByUserTypeStmt->bindParam(':user_type', $user_type, \PDO::PARAM_STR);
        $this->selectRandomByUserTypeStmt->bindParam(':num', $limit, \PDO::PARAM_INT);
        $this->selectRandomByUserTypeStmt->bindParam(':user_status', $status, \PDO::PARAM_INT);
        $this->selectRandomByUserTypeStmt->execute();
        $raw_data = $this->selectRandomByUserTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\{$this->target_class}";
    }

    protected function getCollection( array $raw )
    {
        return new UserCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $this->target_class = ucfirst($array['user_type']);
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setUsername($array['username']);
        $object->setPassword($array['password']);
        $object->setUserType($array['user_type']);
        $object->setStatus($array['status']);
        $personal_info = Models\PersonalInfo::getMapper('PersonalInfo')->find($array['id']);
        //if(! is_null($personal_info))
		 $object->setPersonalInfo($personal_info);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getUsername(),
            $object->getPassword(),
            $object->getUserType(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getUsername(),
            $object->getPassword(),
            $object->getUserType(),
            $object->getStatus(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    protected function doDelete(Models\DomainObject $object )
    {
        $values = array( $object->getId() );
        $this->deleteStmt->execute( $values );
    }

    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }
}