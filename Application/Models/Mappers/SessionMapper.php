<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/31/2015
 * Time:    10:47 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\SessionCollection;
use System\Utilities\DateTime;

class SessionMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare(
            "SELECT * FROM site_sessions WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare(
            "SELECT * FROM site_sessions ORDER BY last_activity_time DESC");
        $this->selectBySessionIdStmt = self::$PDO->prepare(
            "SELECT * FROM site_sessions WHERE session_id=?");
        $this->selectByUserIdStmt = self::$PDO->prepare(
            "SELECT * FROM site_sessions WHERE user_id=? ORDER BY last_activity_time DESC");
        $this->selectByUserTypeStmt = self::$PDO->prepare(
            "SELECT * FROM site_sessions WHERE user_type=? ORDER BY last_activity_time DESC");
        $this->updateStmt = self::$PDO->prepare(
            "UPDATE site_sessions SET session_id=?, user_id=?, user_type=?, start_time=?, user_agent=?, ip_address=?, last_activity_time=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare(
            "INSERT INTO site_sessions (session_id,user_id,user_type,start_time,user_agent,ip_address,last_activity_time,status) VALUES (?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare(
            "DELETE FROM site_sessions WHERE id=?");
    }

    public function findBySessionId($session_id)
    {
        return $this->findHelper($session_id, $this->selectBySessionIdStmt, 'session_id');
    }

    public function findByUserId($user_id)
    {
        $this->selectByUserIdStmt->execute( array($user_id) );
        $raw_data = $this->selectByUserIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByUserType($user_type)
    {
        $this->selectByUserTypeStmt->execute( array($user_type) );
        $raw_data = $this->selectByUserTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Session";
    }

    protected function getCollection( array $raw )
    {
        return new SessionCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setSessionId($array['session_id']);
        $session_user = Models\User::getMapper('User')->find($array['user_id']);
        $object->setSessionUser($session_user);
        $object->setUserType($array['user_type']);
        $object->setStartTime(DateTime::getDateTimeObjFromInt($array['start_time']));
        $object->setUserAgent($array['user_agent'])->setIpAddress($array['ip_address']);
        $object->setLastActivityTime(DateTime::getDateTimeObjFromInt($array['last_activity_time']));
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getSessionId(),
            $object->getSessionUser()->getId(),
            $object->getUserType(),
            $object->getStartTime()->getDateTimeInt(),
            $object->getUserAgent(),
            $object->getIpAddress(),
            $object->getLastActivityTime()->getDateTimeInt(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getSessionId(),
            $object->getSessionUser()->getId(),
            $object->getUserType(),
            $object->getStartTime()->getDateTimeInt(),
            $object->getUserAgent(),
            $object->getIpAddress(),
            $object->getLastActivityTime()->getDateTimeInt(),
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