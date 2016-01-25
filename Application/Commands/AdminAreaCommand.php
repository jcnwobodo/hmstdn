<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    5:14 PM
 */

namespace Application\Commands;

use Application\Models\Category;
use Application\Models\Disease;
use Application\Models\Employee;
use Application\Models\EmploymentData;
use Application\Models\PersonalInfo;
use Application\Models\Post;
use Application\Models\User;
use Application\Models\Comment;
use Application\Models\Location;
use Application\Models\Upload;
use System\Models\DomainObjectWatcher;
use System\Request\RequestContext;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;

class AdminAreaCommand extends AdminAndReceptionistCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, User::UT_ADMIN, 'admin-area'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $approved_comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_APPROVED);
        $pending_comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_PENDING);
        $deleted_comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_DELETED);

        $data = array();
        $data['num_approved_comments'] = $approved_comments ? $approved_comments->size() : 0;
        $data['num_pending_comments'] = $pending_comments ? $pending_comments->size() : 0;
        $data['num_deleted_comments'] = $deleted_comments ? $deleted_comments->size() : 0;

        $data['page-title'] = "Admin Dashboard";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/dashboard.php');
    }

    //Comments management
    protected function ManageComments(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'pending';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $comment_ids = $requestContext->fieldIsSet('comment-ids') ? $requestContext->getField('comment-ids') : array();

        switch(strtolower($action))
        {
            case 'approve' : {
                foreach($comment_ids as $comment_id)
                {
                    $comment_obj = Comment::getMapper('Comment')->find($comment_id);
                    if(is_object($comment_obj)) $comment_obj->setStatus(Comment::STATUS_APPROVED);
                }
            } break;
            case 'delete' : {
                foreach($comment_ids as $comment_id)
                {
                    $comment_obj = Comment::getMapper('Comment')->find($comment_id);
                    if(is_object($comment_obj)) $comment_obj->setStatus(Comment::STATUS_DELETED);
                }
            } break;
            case 'disapprove' : {
                foreach($comment_ids as $comment_id)
                {
                    $comment_obj = Comment::getMapper('Comment')->find($comment_id);
                    if(is_object($comment_obj)) $comment_obj->setStatus(Comment::STATUS_PENDING);
                }
            } break;
            case 'restore' : {
                foreach($comment_ids as $comment_id)
                {
                    $comment_obj = Comment::getMapper('Comment')->find($comment_id);
                    if(is_object($comment_obj)) $comment_obj->setStatus(Comment::STATUS_APPROVED);
                }
            } break;
            case 'delete permanently' : {
                foreach($comment_ids as $comment_id)
                {
                    $comment_obj = Comment::getMapper('Comment')->find($comment_id);
                    if(is_object($comment_obj)) $comment_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'pending' : {
                $comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_PENDING);
            } break;
            case 'approved' : {
                $comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_APPROVED);
            } break;
            case 'deleted' : {
                $comments = Comment::getMapper('Comment')->findByStatus(Comment::STATUS_DELETED);
            } break;
            default : {
                $comments = Comment::getMapper('Comment')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['comments'] = $comments;
        $data['page-title'] = ucwords($status)." Comments";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-comments.php');
    }

    //Categories management
    protected function ManageCategories(RequestContext $requestContext)
    {
        $type = $requestContext->fieldIsSet('type') ? $requestContext->getField('type') : 'post';
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'approved';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $category_ids = $requestContext->fieldIsSet('category-ids') ? $requestContext->getField('category-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = Category::getMapper('Category')->find($category_id);
                    if(is_object($category_obj)) $category_obj->setStatus(Category::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = Category::getMapper('Category')->find($category_id);
                    if(is_object($category_obj)) $category_obj->setStatus(Category::STATUS_APPROVED);
                }
            } break;
            case 'delete permanently' : {
                foreach($category_ids as $category_id)
                {
                    $category_obj = Category::getMapper('Category')->find($category_id);
                    if(is_object($category_obj)) $category_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'approved' : {
                $categories = Category::getMapper('Category')->findTypeByStatus($type, Category::STATUS_APPROVED);
            } break;
            case 'deleted' : {
                $categories = Category::getMapper('Category')->findTypeByStatus($type, Category::STATUS_DELETED);
            } break;
            default : {
                $categories = Category::getMapper('Category')->findAll();
            }
        }

        $data = array();
        $data['type'] = $type;
        $data['status'] = $status;
        $data['categories'] = $categories;
        $data['page-title'] = ucwords($status)." Categories (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-categories.php');
    }

    protected function AddCategory(RequestContext $requestContext)
    {
        $data = array();
        $types = array('post');
        $type = ( $requestContext->fieldIsSet('type') && in_array($requestContext->getField('type'), $types)) ? $requestContext->getField('type') : 'post';
        $data['type'] = $type;

        $fields = $requestContext->getAllFields();
        switch(strtolower($type))
        {
            case(Category::TYPE_POST) : {
                $existing_categories = Category::getMapper('Category')->findTypeByStatus(Category::TYPE_POST, Category::STATUS_APPROVED);
                $data['categories'] = $existing_categories;


                if($requestContext->fieldIsSet('add'))
                {
                    $caption = $fields['category-caption'];
                    $guid = strtolower($fields['category-guid']);
                    $parent = Category::getMapper('Category')->find($fields['category-parent']);

                    if(strlen($caption) and strlen($guid))
                    {
                        $new_category = new Category();
                        $new_category->setGuid($guid);
                        if(is_object($parent)) $new_category->setParent($parent);
                        $new_category->setCaption($caption);
                        $new_category->setType(Category::TYPE_POST);
                        $new_category->setStatus(Category::STATUS_APPROVED);

                        $requestContext->setFlashData("Category '{$caption}' added successfully");
                        $data['status'] = 1;
                    }else{
                        $requestContext->setFlashData('Mandatory fields not set');
                        $data['status'] = 0;
                    }
                }
            }
        }
        DomainObjectWatcher::instance()->performOperations();

        $data['page-title'] = "Add Category (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/add-category.php');
    }

    //Post management
    protected function AddPost(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'create-post';
        $data['page-title'] = "Create News-Post";
        $post_categories = Category::getMapper('Category')->findTypeByStatus(Category::TYPE_POST, Category::STATUS_APPROVED);
        $data['categories'] = $post_categories;

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/post-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processPostEditor($requestContext);
        }
    }

    protected function UpdatePost(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'update-post';
        $data['page-title'] = "Update Post";
        $news_categories = Category::getMapper('Category')->findTypeByStatus(Category::TYPE_POST, Category::STATUS_APPROVED);
        $data['categories'] = $news_categories;

        if($requestContext->fieldIsSet('post-id')) $post = Post::getMapper('Post')->find($requestContext->getField('post-id'));
        $fields = array();
        $fields['post-title'] = $post->getTitle();
        $fields['post-url'] = $post->getGuid();
        $fields['post-content'] = remove_text_formatting($post->getContent());
        $fields['post-excerpt'] = remove_text_formatting($post->getExcerpt());
        $fields['post-category'] = $post->getCategory()->getId();
        $fields['post-date']['month'] = $post->getDateCreated()->getMonth();
        $fields['post-date']['day'] = $post->getDateCreated()->getDay();
        $fields['post-date']['year'] = $post->getDateCreated()->getYear();
        $fields['post-time']['hour'] = date('g', $post->getDateCreated()->getDateTimeInt() );
        $fields['post-time']['minute'] = date('i', $post->getDateCreated()->getDateTimeInt() );
        $fields['post-time']['am_pm'] = date('A', $post->getDateCreated()->getDateTimeInt() );
        $data['post-id'] = $fields['post-id'] = $post->getId();
        $data['fields'] = $fields;

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/post-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processPostEditor($requestContext);
        }

    }

    protected function ManagePosts(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'published';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $post_ids = $requestContext->fieldIsSet('post-ids') ? $requestContext->getField('post-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_PUBLISHED);
                }
            } break;
            case 'un-publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'delete permanently' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'published' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_PUBLISHED);
            } break;
            case 'draft' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_DRAFT);
            } break;
            case 'deleted' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_POST, Post::STATUS_DELETED);
            } break;
            default : {
                $posts = Post::getMapper('Post')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['posts'] = $posts;
        $data['page-title'] = ucwords($status)." News Posts";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-posts.php');
    }

    private function processPostEditor(RequestContext $requestContext)
    {
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields();

        $title = $fields['post-title'];
        $guid = strtolower( str_replace(array(' '), array('-'), $fields['post-url']) );
        $content = $fields['post-content'];
        $excerpt = $fields['post-excerpt'];
        $category = Category::getMapper('Category')->find($fields['post-category']);
        $date = $fields['post-date'];
        $time = $fields['post-time'];
        preProcessTimeArr($time);

        if(
            strlen($title)
            and strlen($guid)
            and strlen($content)
            and is_object($category)
            and checkdate($date['month'], $date['day'], $date['year'])
            and DateTime::checktime($time['hour'], $time['minute'])
        )
        {
            $post = $data['mode'] == 'create-post' ? new Post() : Post::getMapper('Post')->find($data['post-id']);
            if(is_object($post))
            {
                $post->setPostType(Post::TYPE_POST);
                $post->setGuid($guid);
                $post->setTitle($title);
                $post->setContent(format_text($content));
                $post->setExcerpt(format_text($excerpt));
                $post->setCategory($category);
                $post->setAuthor($requestContext->getSession()->getSessionUser());
                $post->setDateCreated(new DateTime(mktime($time['hour'],$time['minute'],0,$date['month'],$date['day'],$date['year'])));
                $post->setLastUpdate(new DateTime());
                $post->setStatus($data['mode'] == 'create-post' ? Post::STATUS_DRAFT : $post->getStatus());

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'create-post' ? "Post created successfully" : "Post updated successfully");

                $data['status'] = 1;
                $data['post-id'] = $post->getId();
                $data['mode'] = 'update-post';
                $data['fields'] = &$fields;
            }
        }else{
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }

    //Page Management
    protected function AddPage(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'create-page';
        $data['page-title'] = "Create Page";

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/page-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processPageEditor($requestContext);
        }
    }

    protected function UpdatePage(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'update-page';
        $data['page-title'] = "Update Page";

        $page = $requestContext->fieldIsSet('page-id') ? Post::getMapper('Post')->find($requestContext->getField('page-id')) : null;
        $fields = array();
        if(is_object($page))
        {
            $fields['page-title'] = $page->getTitle();
            $fields['page-url'] = $page->getGuid();
            $fields['page-content'] = remove_text_formatting($page->getContent());
            $fields['page-excerpt'] = remove_text_formatting($page->getExcerpt());
            $fields['page-date']['month'] = $page->getDateCreated()->getMonth();
            $fields['page-date']['day'] = $page->getDateCreated()->getDay();
            $fields['page-date']['year'] = $page->getDateCreated()->getYear();
            $fields['page-time']['hour'] = date('g', $page->getDateCreated()->getDateTimeInt() );
            $fields['page-time']['minute'] = date('i', $page->getDateCreated()->getDateTimeInt() );
            $fields['page-time']['am_pm'] = date('A', $page->getDateCreated()->getDateTimeInt() );
            $data['page-id'] = $fields['page-id'] = $page->getId();
        }
        $data['fields'] = $fields;

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/page-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processPageEditor($requestContext);
        }

    }

    protected function ManagePages(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'published';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $post_ids = $requestContext->fieldIsSet('page-ids') ? $requestContext->getField('page-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_PUBLISHED);
                }
            } break;
            case 'un-publish' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->setStatus(Post::STATUS_DRAFT);
                }
            } break;
            case 'delete permanently' : {
                foreach($post_ids as $post_id)
                {
                    $post_obj = Post::getMapper('Post')->find($post_id);
                    if(is_object($post_obj)) $post_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'published' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_PAGE, Post::STATUS_PUBLISHED);
            } break;
            case 'draft' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_PAGE, Post::STATUS_DRAFT);
            } break;
            case 'deleted' : {
                $posts = Post::getMapper('Post')->findTypeByStatus(Post::TYPE_PAGE, Post::STATUS_DELETED);
            } break;
            default : {
                $posts = Post::getMapper('Post')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['pages'] = $posts;
        $data['page-title'] = ucwords($status)." Pages";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-pages.php');
    }

    private function processPageEditor(RequestContext $requestContext)
    {
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields();

        $title = $fields['page-title'];
        $guid = strtolower( str_replace(array(' '), array('-'), $fields['page-url']) );
        $content = $fields['page-content'];
        $excerpt = $fields['page-excerpt'];
        $date = $fields['page-date'];
        $time = $fields['page-time'];
        preProcessTimeArr($time);

        if(
            strlen($title)
            and strlen($guid)
            and strlen($content)
            and checkdate($date['month'], $date['day'], $date['year'])
            and DateTime::checktime($time['hour'], $time['minute'])
        )
        {
            $post = $data['mode'] == 'create-page' ? new Post() : Post::getMapper('Post')->find($data['page-id']);
            if(is_object($post))
            {
                $post->setPostType(Post::TYPE_PAGE);
                $post->setGuid($guid);
                $post->setTitle($title);
                $post->setContent(format_text($content));
                $post->setExcerpt(format_text($excerpt));
                $post->setAuthor($requestContext->getSession()->getSessionUser());
                $post->setDateCreated(new DateTime(mktime($time['hour'],$time['minute'],0,$date['month'],$date['day'],$date['year']) ));
                $post->setLastUpdate(new DateTime());
                $post->setStatus($data['mode'] == 'create-page' ? Post::STATUS_DRAFT : $post->getStatus());

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'create-page' ? "Page created successfully" : "Page updated successfully");

                $data['status'] = 1;
                $data['page-id'] = $post->getId();
                $data['mode'] = 'update-page';
                $data['fields'] = &$fields;
            }
        }else{
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }

    //Location Management
    protected function ManageLocations(RequestContext $requestContext)
    {
        $type = $requestContext->fieldIsSet('type') ? $requestContext->getField('type') : 'state';
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'approved';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $location_ids = $requestContext->fieldIsSet('location-ids') ? $requestContext->getField('location-ids') : array();

        switch(strtolower($action))
        {
            case 'approve' : {
                foreach($location_ids as $location_id)
                {
                    $location_obj = Location::getMapper('Location')->find($location_id);
                    if(is_object($location_obj)) $location_obj->setStatus(Location::STATUS_APPROVED);
                }
            } break;
            case 'delete' : {
                foreach($location_ids as $location_id)
                {
                    $location_obj = Location::getMapper('Location')->find($location_id);
                    if(is_object($location_obj)) $location_obj->setStatus(Location::STATUS_DELETED);
                }
            } break;
            case 'disapprove' : {
                foreach($location_ids as $location_id)
                {
                    $location_obj = Location::getMapper('Location')->find($location_id);
                    if(is_object($location_obj)) $location_obj->setStatus(Location::STATUS_PENDING);
                }
            } break;
            case 'restore' : {
                foreach($location_ids as $location_id)
                {
                    $location_obj = Location::getMapper('Location')->find($location_id);
                    if(is_object($location_obj)) $location_obj->setStatus(Location::STATUS_APPROVED);
                }
            } break;
            case 'delete permanently' : {
                foreach($location_ids as $location_id)
                {
                    $location_obj = Location::getMapper('Location')->find($location_id);
                    if(is_object($location_obj)) $location_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'pending' : {
                $locations = Location::getMapper('Location')->findTypeByStatus($type, Location::STATUS_PENDING);
            } break;
            case 'approved' : {
                $locations = Location::getMapper('Location')->findTypeByStatus($type, Location::STATUS_APPROVED);
            } break;
            case 'deleted' : {
                $locations = Location::getMapper('Location')->findTypeByStatus($type, Location::STATUS_DELETED);
            } break;
            default : {
                $locations = Location::getMapper('Location')->findAll();
            }
        }

        $data = array();
        $data['type'] = $type;
        $data['status'] = $status;
        $data['locations'] = $locations;
        $data['page-title'] = ucwords($status)." Locations (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-locations.php');
    }

    protected function AddLocation(RequestContext $requestContext)
    {
        $data = array();
        $types = array('state', 'lga', 'district');
        $type = ( $requestContext->fieldIsSet('type') && in_array($requestContext->getField('type'), $types)) ? $requestContext->getField('type') : 'district';
        $data['type'] = $type;

        $fields = $requestContext->getAllFields();
        switch(strtolower($type))
        {
            case(Location::TYPE_STATE) : {
                if($requestContext->fieldIsSet('add'))
                {
                    //process state-add request
                    $name = $fields['location-name'];
                    $slogan = $fields['location-slogan'];
                    $latitude = $fields['location-coordinates']['latitude'];
                    $longitude = $fields['location-coordinates']['longitude'];

                    if(strlen($name) and strlen($slogan) and is_numeric($latitude) and is_numeric($longitude))
                    {
                        $new_location = new Location();
                        $new_location->setLocationName($name);
                        $new_location->setSlogan($slogan);
                        $new_location->setLatitude($latitude);
                        $new_location->setLongitude($longitude);
                        $new_location->setLocationType(Location::TYPE_STATE);
                        $new_location->setStatus(Location::STATUS_APPROVED);

                        $requestContext->setFlashData("{$name} state added successfully");
                        $data['status'] = 1;
                    }else{
                        $requestContext->setFlashData('Mandatory fields not set');
                        $data['status'] = 0;
                    }
                }
            } break;
            case(Location::TYPE_LGA) : {
                $all_states = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);
                $data['states'] = $all_states;

                if($requestContext->fieldIsSet('add'))
                {
                    //process LGA-add request
                    $name = $fields['location-name'];
                    $slogan = $fields['location-slogan'];
                    $parent_state = Location::getMapper('Location')->find($fields['parent-state']);
                    $latitude = $fields['location-coordinates']['latitude'];
                    $longitude = $fields['location-coordinates']['longitude'];

                    if(strlen($name) and is_object($parent_state) and is_numeric($latitude) and is_numeric($longitude))
                    {
                        $new_location = new Location();
                        $new_location->setParent($parent_state);
                        $new_location->setLocationName($name);
                        $new_location->setSlogan($slogan);
                        $new_location->setLatitude($latitude);
                        $new_location->setLongitude($longitude);
                        $new_location->setLocationType(Location::TYPE_LGA);
                        $new_location->setStatus(Location::STATUS_APPROVED);

                        $requestContext->setFlashData("{$name} LGA added successfully");
                        $data['status'] = 1;
                    }else{
                        $requestContext->setFlashData('Mandatory fields not set');
                        $data['status'] = 0;
                    }
                }
            } break;
            case(Location::TYPE_DISTRICT) : {
                $all_states = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);
                $all_lgas = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_LGA, Location::STATUS_APPROVED);
                $data['states'] = $all_states;
                $data['lgas'] = $all_lgas;

                if($requestContext->fieldIsSet('add'))
                {
                    //process District-add request
                    $name = $fields['location-name'];
                    $slogan = $fields['location-slogan'];
                    $parent_state = Location::getMapper('Location')->find($fields['parent-state']);
                    $parent_lga = Location::getMapper('Location')->find($fields['parent-lga']);
                    $latitude = $fields['location-coordinates']['latitude'];
                    $longitude = $fields['location-coordinates']['longitude'];

                    if(strlen($name) and is_object($parent_state) and is_object($parent_lga) and $parent_lga->getParent() == $parent_state and is_numeric($latitude) and is_numeric($longitude))
                    {
                        $new_location = new Location();
                        $new_location->setParent($parent_lga);
                        $new_location->setLocationName($name);
                        $new_location->setSlogan($slogan);
                        $new_location->setLatitude($latitude);
                        $new_location->setLongitude($longitude);
                        $new_location->setLocationType(Location::TYPE_DISTRICT);
                        $new_location->setStatus(Location::STATUS_APPROVED);

                        $requestContext->setFlashData("District '{$name}' added successfully");
                        $data['status'] = 1;
                    }else{
                        $requestContext->setFlashData('Mandatory fields not set');
                        $data['status'] = 0;
                    }
                }
            }
        }
        DomainObjectWatcher::instance()->performOperations();

        $data['page-title'] = "Add Location (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/add-location.php');
    }

    //User Management
    protected function ManageUsers(RequestContext $requestContext)
    {
        $types = array('admin', 'doctor', 'lab_technician', 'receptionist');
        $type = ($requestContext->fieldIsSet('type') and in_array($requestContext->getField('type'), $types)) ? $requestContext->getField('type') : 'doctor';
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'active';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $user_ids = $requestContext->fieldIsSet('user-ids') ? $requestContext->getField('user-ids') : array();

        switch(strtolower($action))
        {
            case 'activate' : {
                foreach($user_ids as $user_id)
                {
                    $user_obj = User::getMapper('User')->find($user_id);
                    if(is_object($user_obj)) $user_obj->setStatus(User::STATUS_ACTIVE);
                }
            } break;
            case 'delete' : {
                foreach($user_ids as $user_id)
                {
                    $user_obj = User::getMapper('User')->find($user_id);
                    if(is_object($user_obj)) $user_obj->setStatus(User::STATUS_DELETED);
                }
            } break;
            case 'deactivate' : {
                foreach($user_ids as $user_id)
                {
                    $user_obj = User::getMapper('User')->find($user_id);
                    if(is_object($user_obj)) $user_obj->setStatus(User::STATUS_INACTIVE);
                }
            } break;
            case 'restore' : {
                foreach($user_ids as $user_id)
                {
                    $user_obj = User::getMapper('User')->find($user_id);
                    if(is_object($user_obj)) $user_obj->setStatus(User::STATUS_ACTIVE);
                }
            } break;
            case 'delete permanently' : {
                foreach($user_ids as $user_id)
                {
                    $user_obj = User::getMapper('User')->find($user_id);
                    if(is_object($user_obj))
                    {
                        $user_obj->getPersonalInfo()->markDelete();
                        if($user_obj instanceof Employee) $user_obj->getEmploymentData()->markDelete();
                        $user_obj->markDelete();
                    }
                }
            } break;
            default : {}
        }
        if(!is_null($action)) DomainObjectWatcher::instance()->performOperations();

        $type_t = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)));
        switch($status)
        {
            case 'active' : {
                $users = Employee::getMapper('Employee')->findTypeByStatus($type_t, User::STATUS_ACTIVE);
            } break;
            case 'inactive' : {
                $users = Employee::getMapper('Employee')->findTypeByStatus($type_t, User::STATUS_INACTIVE);
            } break;
            case 'deleted' : {
                $users = Employee::getMapper('Employee')->findTypeByStatus($type_t, User::STATUS_DELETED);
            } break;
            default : {
                $users = Employee::getMapper('Employee')->findAll();
            }
        }

        $data = array();
        $data['type'] = $type;
        $data['status'] = $status;
        $data['users'] = $users;
        $data['page-title'] = ucwords($status)." Staff Members (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-users.php');
    }

    protected function AddUser(RequestContext $requestContext)
    {
        $data = array();
        $types = array('admin-area', 'doctor', 'lab_technician', 'receptionist');
        $type = ( $requestContext->fieldIsSet('type') && in_array($requestContext->getField('type'), $types)) ? $requestContext->getField('type') : 'doctor';
        $data['type'] = $type;

        if($requestContext->fieldIsSet("add"))
        {
            $data['status'] = false;
            $fields = $requestContext->getAllFields();

            $first_name = $fields['first-name'];
            $last_name = $fields['last-name'];
            $other_names = $fields['other-names'];
            $gender = $fields['gender'];
            $dob = $fields['date-of-birth'];
            $nationality = $fields['nationality'];
            $state_of_origin = $fields['state-of-origin'];
            $lga_of_origin = $fields['lga-of-origin'];
            $res_country = $fields['residence-country'];
            $res_state = $fields['residence-state'];
            $res_city = $fields['residence-city'];
            $res_street = $fields['residence-street'];
            $contact_email = $fields['contact-email'];
            $contact_phone = $fields['contact-phone'];
            $passport = !empty($_FILES['passport-photo']) ? $requestContext->getFile('passport-photo') : null;
            $employee_id = $fields['employee-id'];
            $department = $fields['department'];
            $specialization = $fields['specialization'];
            $password1 = $fields['password1'];
            $password2 = $fields['password2'];

            $date_is_correct = checkdate($dob['month'], $dob['day'], $dob['year']);
            /*Ensure that mandatory data is supplied, then create a report object*/
            if(
                strlen($first_name)
                and strlen($last_name)
                //and in_array(strtolower($gender),PersonalInfo::$gender_enum)
                //and $date_is_correct
                //and strlen($nationality)
                //and strlen($state_of_origin)
                //and strlen($lga_of_origin)
                //and strlen($res_country)
                //and strlen($res_state)
                //and strlen($res_city)
                //and strlen($res_street)
                //and strlen($contact_email)
                //and (strlen($contact_phone)==11)
                //and !is_null($passport)
                and strlen($employee_id)
                and strlen($department)
                and strlen($specialization)
                and strlen($password1) and $password1 === $password2
            )
            {
                $date_of_birth = new DateTime(mktime(0,0,0,$dob['month'],$dob['day'],$dob['year']));

                if(!is_null($passport))
				{
				//Handle photo upload
                $photo_handled = false;
                $uploader = new UploadHandler('passport-photo', uniqid('passport_'));
                $uploader->setAllowedExtensions(array('jpg'));
                $uploader->setUploadDirectory("Uploads/passports");
                $uploader->setMaxUploadSize(0.2);
                $uploader->doUpload();

                if($uploader->getUploadStatus())
                {
                    $photo = new Upload();
                    //$photo->setAuthor($profile);
                    $photo->setUploadTime(new DateTime());
                    $photo->setLocation($uploader->getUploadDirectory());
                    $photo->setFileName($uploader->getOutputFileName().".".$uploader->getFileExtension());
                    $photo->setFileSize($uploader->getFileSize());

                    $photo_handled = true;
                }
                else
                {
                    $data['status'] = false;
                    $requestContext->setFlashData("Error Uploading Photo - ".$uploader->getStatusMessage());
                }
				}
				
                if(1)//$photo_handled)
                {
                    $user_class = str_replace(' ', '', ucwords(str_replace('_', ' ', $type)) );
                    $class = "\\Application\\Models\\".$user_class;
                    $user = new $class();
                    $user->setUsername(strtolower($employee_id));
                    $user->setPassword($password1);
                    $user->setUserType($user_class);
                    $user->setStatus(User::STATUS_ACTIVE);
                    $user->mapper()->insert($user);

                    $profile = new PersonalInfo();
                    $profile->setId($user->getId());
                    if($photo_handled) $profile->setProfilePhoto($photo);
                    $profile->setFirstName($first_name);
                    $profile->setLastName($last_name);
                    $profile->setOtherNames($other_names);
                    $profile->setGender($gender);
                    $profile->setDateOfBirth($date_of_birth);
                    $profile->setNationality($nationality);
                    $profile->setStateOfOrigin($state_of_origin);
                    $profile->setLga($lga_of_origin);
                    $profile->setResidenceCountry($res_country);
                    $profile->setResidenceState($res_state);
                    $profile->setResidenceCity($res_city);
                    $profile->setResidenceStreet($res_street);
                    $profile->setEmail(strtolower($contact_email));
                    $profile->setPhone($contact_phone);

                    $emp_data = new EmploymentData();
                    $emp_data->setId($user->getId());
                    $emp_data->setDepartment($department);
                    $emp_data->setSpecialization($specialization);

                    $requestContext->setFlashData("Staff profile has been created successfully.");
                    $data['status'] = true;
                }
            }
            else{
                $data['status'] = false;
                $requestContext->setFlashData("Please fill out all fields with valid data, then try again.");

                //Try returning more helpful error messages
                if($password1 !== $password2) $requestContext->setFlashData("Password confirmation does not match");
                if(!$date_is_correct) $requestContext->setFlashData("Please supply a valid date for date of birth");
            }
        }

        $data['page-title'] = "Add Staff (".ucwords($type).")";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/add-user.php');
    }

    //Disease management
    protected function ManageDiseases(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'approved';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $disease_ids = $requestContext->fieldIsSet('disease-ids') ? $requestContext->getField('disease-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($disease_ids as $disease_id)
                {
                    $disease_obj = Disease::getMapper('Disease')->find($disease_id);
                    if(is_object($disease_obj)) $disease_obj->setStatus(Disease::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($disease_ids as $disease_id)
                {
                    $disease_obj = Disease::getMapper('Disease')->find($disease_id);
                    if(is_object($disease_obj)) $disease_obj->setStatus(Disease::STATUS_APPROVED);
                }
            } break;
            case 'delete permanently' : {
                foreach($disease_ids as $disease_id)
                {
                    $disease_obj = Disease::getMapper('Disease')->find($disease_id);
                    if(is_object($disease_obj)) $disease_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'approved' : {
                $diseases = Disease::getMapper('Disease')->findByStatus(Disease::STATUS_APPROVED);
            } break;
            case 'deleted' : {
                $diseases = Disease::getMapper('Disease')->findByStatus(Disease::STATUS_DELETED);
            } break;
            default : {
                $diseases = Disease::getMapper('Disease')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['diseases'] = $diseases;
        $data['page-title'] = ucwords($status)." Diseases";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-diseases.php');
    }

    protected function AddDisease(RequestContext $requestContext)
    {
        $data = array();

        $fields = $requestContext->getAllFields();
        if($requestContext->fieldIsSet('add'))
        {
            $name = $fields['name'];
            $causes = format_text($fields['causes']);
            $signs = format_text($fields['signs']);

            if(strlen($name) and strlen($causes) and strlen($signs))
            {
                $disease = new Disease();
                $disease->setName($name)->setCausativeOrganisms($causes)->setSignsAndSymptoms($signs)->setStatus(Disease::STATUS_APPROVED);

                $requestContext->setFlashData("Disease '{$name}' added successfully");
                $data['status'] = 1;
            }
            else
            {
                $requestContext->setFlashData('Mandatory fields not set');
                $data['status'] = 0;
            }
        }
        DomainObjectWatcher::instance()->performOperations();

        $data['page-title'] = "Add Disease";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/add-disease.php');
    }

}