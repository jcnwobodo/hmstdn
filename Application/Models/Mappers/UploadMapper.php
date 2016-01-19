<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:10 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\UploadCollection;
use System\Utilities\DateTime;

class UploadMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_uploads WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_uploads");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM site_uploads WHERE status=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_uploads SET author=?, upload_time=?, location=?, file_name=?, file_size=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_uploads (author,upload_time,location,file_name,file_size,status)VALUES(?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_uploads WHERE id=?");
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Upload";
    }

    protected function getCollection( array $raw )
    {
        return new UploadCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $author = Models\User::getMapper('User')->find($array['author']);
        if(is_object($author)) $object->setAuthor($author);
        $object->setUploadTime(DateTime::getDateTimeObjFromInt($array['upload_time']));
        $object->setLocation($array['location']);
        $object->setFileName($array['file_name']);
        $object->setFileSize($array['file_size']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            is_object($object->getAuthor()) ? $object->getAuthor()->getId() : NULL,
            $object->getUploadTime()->getDateTimeInt(),
            $object->getLocation(),
            $object->getFileName(),
            $object->getFileSize(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            is_object($object->getAuthor()) ? $object->getAuthor()->getId() : NULL,
            $object->getUploadTime()->getDateTimeInt(),
            $object->getLocation(),
            $object->getFileName(),
            $object->getFileSize(),
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