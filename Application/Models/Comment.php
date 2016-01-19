<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackmarket
 * Date:    11/16/2015
 * Time:    10:34 PM
 */

namespace Application\Models;

use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class Comment extends DomainObject implements I_StatefulObject
{
    private $parent;
    private $post_id;
    private $comment_author;
    private $comment_time;
    private $comment_type;
    private $content;
    private $status;

    const COMMENT_TYPE_POST = 'post';
    const COMMENT_TYPE_REPORT = 'report';

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return Comment
     */
    public function setParent(self $parent)
    {
        $this->parent = $parent;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     * @return Comment
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentAuthor()
    {
        return $this->comment_author;
    }

    /**
     * @param mixed $comment_author
     * @return Comment
     */
    public function setCommentAuthor(User $comment_author)
    {
        $this->comment_author = $comment_author;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentTime()
    {
        return $this->comment_time;
    }

    /**
     * @param mixed $comment_time
     * @return Comment
     */
    public function setCommentTime(DateTime $comment_time)
    {
        $this->comment_time = $comment_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentType()
    {
        return $this->comment_type;
    }

    /**
     * @param mixed $comment_type
     * @return Comment
     */
    public function setCommentType($comment_type)
    {
        $this->comment_type = $comment_type;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return Comment
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}