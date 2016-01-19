<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/23/2015
 * Time:    3:11 AM
 **/

namespace Application\Models\Mappers;

use Application\Models;
use System\Utilities\DateTime;
use Application\Models\Collections\CommentCollection;

class CommentMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_comments WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_comments");
        $this->selectByPostStmt = self::$PDO->prepare("SELECT * FROM site_comments WHERE post_id=?");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM site_comments WHERE status=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_comments set parent=?, post_id=?, comment_author=?, comment_time=?, comment_type=?, content=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_comments (parent, post_id, comment_author, comment_time, comment_type, content, status) VALUES (?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_comments WHERE id=?");
        $this->deleteByPostStmt = self::$PDO->prepare("DELETE FROM site_comments WHERE post_id=?");
    }

    public function findByPost($post_id)
    {
        $this->selectByPostStmt->execute( array($post_id) );
        $raw_data = $this->selectByPostStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function deleteByPostId($post_id)
    {
        $values = array( $post_id );
        $this->deleteByPostStmt->execute( $values );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Comment";
    }

    protected function getCollection( array $raw )
    {
        return new CommentCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $parent = $this->find($array['parent']);
        if(! is_null($parent)) $object->setParent($parent);
        $object->setPostId($array['post_id']);
        $author = Models\User::getMapper('User')->find($array['comment_author']);
        if(is_object($author)) $object->setCommentAuthor($author);
        $object->setCommentTime(DateTime::getDateTimeObjFromInt($array['comment_time']));
        $object->setCommentType($array['comment_type']);
        $object->setContent($array['content']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $parent_id = is_object($object->getParent()) ? $object->getParent()->getId() : NULL;
        $values = array(
            $parent_id,
            $object->getPostId(),
            $object->getCommentAuthor()->getId(),
            $object->getCommentTime()->getDateTimeInt(),
            $object->getCommentType(),
            $object->getContent(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $parent_id = is_object($object->getParent()) ? $object->getParent()->getId() : NULL;
        $values = array(
            $parent_id,
            $object->getPostId(),
            $object->getCommentAuthor()->getId(),
            $object->getCommentTime()->getDateTimeInt(),
            $object->getCommentType(),
            $object->getContent(),
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