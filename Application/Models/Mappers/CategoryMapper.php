<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    11:56 AM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\CategoryCollection;

class CategoryMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_categories WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_categories");
        $this->selectByPamalinkStmt = self::$PDO->prepare("SELECT * FROM site_categories WHERE guid=?");
        $this->selectByParentStmt = self::$PDO->prepare("SELECT * FROM site_categories WHERE parent=? ORDER BY caption");
        $this->selectByTypeStmt = self::$PDO->prepare("SELECT * FROM site_categories WHERE type=? ORDER BY caption");
        $this->selectTypeByStatusStmt = self::$PDO->prepare("SELECT * FROM site_categories WHERE type=? AND status=? ORDER BY caption");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_categories set guid=?, parent=?, caption=?, type=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_categories (guid,parent,caption,type,status)VALUES(?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_categories WHERE id=?");
    }

    public function findByPamalink($pamalink)
    {
        return $this->findHelper($pamalink, $this->selectByPamalinkStmt, 'guid');
    }

    public function findByParent($parent_id)
    {
        $this->selectByParentStmt->execute( array($parent_id) );
        $raw_data = $this->selectByParentStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByType($type)
    {
        $this->selectByTypeStmt->execute( array($type) );
        $raw_data = $this->selectByTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findTypeByStatus($type, $status)
    {
        $this->selectTypeByStatusStmt->execute( array($type, $status) );
        $raw_data = $this->selectTypeByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Category";
    }

    protected function getCollection( array $raw )
    {
        return new CategoryCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setGuid($array['guid']);

        //parent category
        $parent_category = Models\Category::getMapper("Category")->find($array['parent']);
        if( ! is_null($parent_category)) $object->setParent($parent_category);

        $object->setCaption($array['caption']);
        $object->setType($array['type']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getGuid(),
            $object->getParent(),
            $object->getCaption(),
            $object->getType(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getGuid(),
            $object->getParent(),
            $object->getCaption(),
            $object->getType(),
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