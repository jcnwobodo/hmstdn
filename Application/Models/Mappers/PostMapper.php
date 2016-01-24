<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/24/2015
 * Time:    10:26 PM
 */

namespace Application\Models\Mappers;

use \Application\Models;
use \Application\Models\Collections\PostCollection;
use \System\Utilities\DateTime;

class PostMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_posts ORDER BY id DESC;");
        $this->selectByTypeStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE post_type=:post_type ORDER BY id DESC LIMIT :row_count OFFSET :offset;");
        $this->selectByPamalinkStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE guid=?");
        $this->selectByCategoryStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE category=? AND status=? ORDER BY id DESC;");
        $this->selectByAuthorStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE author=? ORDER BY id DESC;");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE status=? ORDER BY ? DESC;");
        $this->selectTypeByStatusStmt = self::$PDO->prepare("SELECT * FROM site_posts WHERE post_type=:post_type AND status=:post_status ORDER BY id DESC LIMIT :row_count OFFSET :offset;");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_posts SET post_type=?, guid=?, title=?, content=?, excerpt=?, featured_image=?, category=?, author=?, date_created=?, last_update=?, comment_count=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_posts (post_type,guid,title,content,excerpt,featured_image,category,author,date_created,last_update,comment_count,status)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_posts WHERE id=?");
    }

    public function findByType($post_type,$row_count=10,$offset=0)
    {
        $this->selectByTypeStmt->bindParam(':post_type', $post_type, \PDO::PARAM_STR);
        $this->selectByTypeStmt->bindParam(':row_count', $row_count, \PDO::PARAM_INT);
        $this->selectByTypeStmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $this->selectByTypeStmt->execute();
        $raw_data = $this->selectByTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByPamalink($pamalink)
    {
        return $this->findHelper($pamalink, $this->selectByPamalinkStmt, 'guid');
    }

    public function findByCategory($category,$status=1)
    {
        $this->selectByCategoryStmt->execute( array($category,$status) );
        $raw_data = $this->selectByCategoryStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByStatus($status, $order='id')
    {
        $this->selectByStatusStmt->execute( array($status, $order) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findTypeByStatus($post_type, $post_status, $row_count=10, $offset=0)
    {
        $this->selectTypeByStatusStmt->bindParam(':post_type', $post_type, \PDO::PARAM_STR);
        $this->selectTypeByStatusStmt->bindParam(':post_status', $post_status, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->bindParam(':row_count', $row_count, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $this->selectTypeByStatusStmt->execute();
        $raw_data = $this->selectTypeByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByAuthor($user_id)
    {
        $this->selectByAuthorStmt->execute( array($user_id) );
        $raw_data = $this->selectByAuthorStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Post";
    }

    protected function getCollection( array $raw )
    {
        return new PostCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setPostType($array['post_type']);
        $object->setGuid($array['guid']);
        $object->setTitle($array['title']);
        $object->setContent($array['content']);
        $object->setExcerpt($array['excerpt']);

        //featured image
        $post_featured_image = Models\Upload::getMapper("Upload")->find($array['featured_image']);
        if(! is_null($post_featured_image)) $object->setFeaturedImage($post_featured_image);

        //category
        $post_category = Models\Category::getMapper("Category")->find($array['category']);
        if(! is_null($post_category)) $object->setCategory($post_category);

        //author
        $post_author = Models\User::getMapper("User")->find($array['author']);
        $object->setAuthor($post_author);

        $object->setDateCreated(DateTime::getDateTimeObjFromInt($array['date_created']));
        $object->setLastUpdate(DateTime::getDateTimeObjFromInt($array['last_update']));
        $object->setCommentCount($array['comment_count']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getPostType(),
            $object->getGuid(),
            $object->getTitle(),
            $object->getContent(),
            $object->getExcerpt(),
            is_object($object->getFeaturedImage()) ? $object->getFeaturedImage()->getId() : NULL,
            is_object($object->getCategory()) ? $object->getCategory()->getId() : NULL,
            $object->getAuthor()->getId(),
            $object->getDateCreated()->getDateTimeInt(),
            $object->getLastUpdate()->getDateTimeInt(),
            $object->getCommentCount(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getPostType(),
            $object->getGuid(),
            $object->getTitle(),
            $object->getContent(),
            $object->getExcerpt(),
            is_object($object->getFeaturedImage()) ? $object->getFeaturedImage()->getId() : NULL,
            is_object($object->getCategory()) ? $object->getCategory()->getId() : NULL,
            $object->getAuthor()->getId(),
            $object->getDateCreated()->getDateTimeInt(),
            $object->getLastUpdate()->getDateTimeInt(),
            $object->getCommentCount(),
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