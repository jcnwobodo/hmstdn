<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/24/2015
 * Time:    12:51 PM
 */

namespace Application\Models;

use System\Utilities\DateTime;

class Post extends DomainObject
{
    private $parent;
    private $post_type;
    private $guid;
    private $title;
    private $content;
    private $excerpt;
    private $featured_image = null;
    private $category = null;
    private $author;
    private $date_created;
    private $last_update;
    private $comment_count;
    private $status;

    const STATUS_DELETED = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    const TYPE_POST = 'post';
    const TYPE_PAGE = 'page';

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    public function getParent()
    {
        return $this->parent;
    }
    public function setParent($parent)
    {
        $this->parent = $parent;
        $this->markDirty();
        return $this;
    }

    public function getPostType()
    {
        return $this->post_type;
    }
    public function setPostType($post_type)
    {
        $this->post_type = $post_type;
        $this->markDirty();
        return $this;
    }

    public function getGuid()
    {
        return $this->guid;
    }
    public function setGuid($guid)
    {
        $this->guid = $guid;
        $this->markDirty();
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
        $this->markDirty();
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setContent($content)
    {
        $this->content = $content;
        $this->markDirty();
        return $this;
    }

    public function getExcerpt()
    {
        return (remove_text_formatting($this->excerpt) ? $this->excerpt : subwords($this->content,0,150) );
    }
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
        $this->markDirty();
        return $this;
    }

    public function getFeaturedImage()
    {
        return $this->featured_image;
    }
    public function setFeaturedImage(Upload $featured_image)
    {
        $this->featured_image = $featured_image;
        $this->markDirty();
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory(Category $category)
    {
        $this->category = $category;
        $this->markDirty();
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }
    public function setAuthor(User $author)
    {
        $this->author = $author;
        $this->markDirty();
        return $this;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }
    public function setDateCreated(DateTime $date_created)
    {
        $this->date_created = $date_created;
        $this->markDirty();
        return $this;
    }

    public function getLastUpdate()
    {
        return $this->last_update;
    }
    public function setLastUpdate(DateTime $last_update)
    {
        $this->last_update = $last_update;
        $this->markDirty();
        return $this;
    }
    /**
     * @return mixed
     */
    public function getCommentCount()
    {
        return $this->comment_count;
    }

    /**
     * @param mixed $comment_count
     * @return Post
     */
    public function setCommentCount($comment_count)
    {
        $this->comment_count = $comment_count;
        return $this;
    }

    public function incrementCommentCount()
    {
        $this->comment_count++;
        $this->markDirty();
    }


    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }
}