<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    7:29 PM
 **/

namespace Application\Commands;


use Application\Models\Clinic;
use Application\Models\User;
use Application\Models\Patient;
use Application\Models\Doctor;
use Application\Models\PersonalInfo;
use Application\Models\Consultation;
use Application\Models\Location;
use Application\Models\Category;
use Application\Models\Post;
use Application\Models\Comment;
use System\Request\RequestContext;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;
use System\Models\DomainObjectWatcher;

abstract class AdminAndReceptionistCommand extends EmployeeCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, array(User::UT_ADMIN, User::UT_RECEPTIONIST), 'admin-area'))
        {
            parent::execute($requestContext);
        }
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

    //Patient Management
    protected function ManagePatients(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'active';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $patient_ids = $requestContext->fieldIsSet('patient-ids') ? $requestContext->getField('patient-ids') : array();

        switch(strtolower($action))
        {
            case 'activate' : {
                foreach($patient_ids as $patient_id)
                {
                    $patient_obj = Patient::getMapper('Patient')->find($patient_id);
                    if(is_object($patient_obj)) $patient_obj->setStatus(Patient::STATUS_ACTIVE);
                }
            } break;
            case 'delete' : {
                foreach($patient_ids as $patient_id)
                {
                    $patient_obj = Patient::getMapper('Patient')->find($patient_id);
                    if(is_object($patient_obj)) $patient_obj->setStatus(Patient::STATUS_DELETED);
                }
            } break;
            case 'deactivate' : {
                foreach($patient_ids as $patient_id)
                {
                    $patient_obj = Patient::getMapper('Patient')->find($patient_id);
                    if(is_object($patient_obj)) $patient_obj->setStatus(Patient::STATUS_INACTIVE);
                }
            } break;
            case 'restore' : {
                foreach($patient_ids as $patient_id)
                {
                    $patient_obj = Patient::getMapper('Patient')->find($patient_id);
                    if(is_object($patient_obj)) $patient_obj->setStatus(Patient::STATUS_ACTIVE);
                }
            } break;
            case 'delete permanently' : {
                foreach($patient_ids as $patient_id)
                {
                    $patient_obj = Patient::getMapper('Patient')->find($patient_id);
                    if(is_object($patient_obj))
                    {
                        $patient_obj->markDelete();
                    }
                }
            } break;
            default : {}
        }
        if(!is_null($action)) DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'active' : {
                $patients = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_ACTIVE);
            } break;
            case 'inactive' : {
                $patients = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_INACTIVE);
            } break;
            case 'deleted' : {
                $patients = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_DELETED);
            } break;
            default : {
                $patients = Employee::getMapper('Employee')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['patients'] = $patients;
        $data['page-title'] = ucwords($status)." Patients";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-patients.php');
    }

    protected function AddPatient(RequestContext $requestContext)
    {
        $data = array();
        $data['location-states'] = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);

        if($requestContext->fieldIsSet("add"))
        {
            $data['status'] = false;
            $fields = $requestContext->getAllFields();

            $card_number = $fields['card-number'];
            $blood_group = $fields['blood-group'];
            $genotype = $fields['genotype'];
            $first_name = $fields['first-name'];
            $last_name = $fields['last-name'];
            $other_names = $fields['other-names'];
            $gender = $fields['gender'];
            $dob = $fields['date-of-birth'];
            /*
            $nationality = $fields['nationality'];
            $state_of_origin = $fields['state-of-origin'];
            $lga_of_origin = $fields['lga-of-origin'];
            $res_country = $fields['residence-country'];
            */
            $res_state = $fields['residence-state'];
            /*
            $res_city = $fields['residence-city'];
            */
            $res_street = $fields['residence-street'];
            $contact_email = $fields['contact-email'];
            $contact_phone = $fields['contact-phone'];
            /*
            $passport = !empty($_FILES['passport-photo']) ? $requestContext->getFile('passport-photo') : null;
            */

            $date_is_correct = checkdate($dob['month'], $dob['day'], $dob['year']);
            $card_number_is_unique = is_null(Patient::getMapper('Patient')->findByCardNumber($card_number));
            $phone_number_is_unique = is_null(PersonalInfo::getMapper('PersonalInfo')->findByPhone($contact_phone));
            /*Ensure that mandatory data is supplied, then create a report object*/
            if(
                is_numeric($card_number) and strlen($card_number)==6 and $card_number_is_unique
                and strlen($blood_group)
                and strlen($genotype)
                and strlen($first_name)
                and strlen($last_name)
                and in_array(strtolower($gender),PersonalInfo::$gender_enum)
                and $date_is_correct
                //and strlen($nationality)
                //and strlen($state_of_origin)
                //and strlen($lga_of_origin)
                //and strlen($res_country)
                and strlen($res_state)
                //and strlen($res_city)
                and strlen($res_street)
                //and strlen($contact_email)
                and (strlen($contact_phone)==11) and $phone_number_is_unique
                //and !is_null($passport)
            )
            {
                $date_of_birth = new DateTime(mktime(0,0,0,$dob['month'],$dob['day'],$dob['year']));

                /*
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
                */
				

                if(1)//$photo_handled)
                {
                    $patient = new Patient();
                    $patient->setCardNumber($card_number);
                    $patient->setBloodGroup($blood_group);
                    $patient->setGenotype($genotype);
                    $patient->setStatus(Patient::STATUS_ACTIVE);
                    $patient->mapper()->insert($patient);

					
                    $profile = new PersonalInfo();
                    $profile->setId('p'.$patient->getId());
                    /*
                    if($photo_handled) $profile->setProfilePhoto($photo);
                    */
                    $profile->setFirstName($first_name);
                    $profile->setLastName($last_name);
                    $profile->setOtherNames($other_names);
                    $profile->setGender($gender);
                    $profile->setDateOfBirth($date_of_birth);
                    /*
                    $profile->setNationality($nationality);
                    $profile->setStateOfOrigin($state_of_origin);
                    $profile->setLga($lga_of_origin);
                    $profile->setResidenceCountry($res_country);
                    */
                    $profile->setResidenceState($res_state);
                    /*
                    $profile->setResidenceCity($res_city);
                    */
                    $profile->setResidenceStreet($res_street);
                    $profile->setEmail(strtolower($contact_email));
                    $profile->setPhone($contact_phone);

                    $patient->setPersonalInfo($profile);
					

                    $requestContext->setFlashData("Patient profile has been created successfully.");
                    $data['status'] = true;
                }
            }
            else{
                $data['status'] = false;
                $requestContext->setFlashData("Please fill out all fields with valid data, then try again.");

                //Try returning more helpful error messages
                if(strlen($card_number) != 6 or !is_numeric($card_number)) $requestContext->setFlashData("Card-Number must be a 6-digit number");
                if(!$date_is_correct) $requestContext->setFlashData("Please supply a valid date for date of birth");
                if(!$card_number_is_unique) $requestContext->setFlashData("Card number must be unique");
            }
        }

        $data['page-title'] = "Add Patient";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/add-patient.php');
    }

    //Consultations management
    protected function ManageConsultations(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'booked';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $consultation_ids = $requestContext->fieldIsSet('consultation-ids') ? $requestContext->getField('consultation-ids') : array();

        switch(strtolower($action))
        {
            case 'cancel' : {
                foreach($consultation_ids as $consultation_id)
                {
                    $consultation_obj = Consultation::getMapper('Consultation')->find($consultation_id);
                    if(is_object($consultation_obj)) $consultation_obj->setStatus(Consultation::STATUS_CANCELED);
                }
            } break;
            case 'restore' : {
                foreach($consultation_ids as $consultation_id)
                {
                    $consultation_obj = Consultation::getMapper('Consultation')->find($consultation_id);
                    if(is_object($consultation_obj)) $consultation_obj->setStatus(Consultation::STATUS_BOOKED);
                }
            } break;
            case 'delete permanently' : {
                foreach($consultation_ids as $consultation_id)
                {
                    $consultation_obj = Consultation::getMapper('Consultation')->find($consultation_id);
                    if(is_object($consultation_obj)) $consultation_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'booked' : {
                $consultations = Consultation::getMapper('Consultation')->findByStatus(Consultation::STATUS_BOOKED);
            } break;
            case 'canceled' : {
                $consultations = Consultation::getMapper('Consultation')->findByStatus(Consultation::STATUS_CANCELED);
            } break;
            case 'completed' : {
                $consultations = Consultation::getMapper('Consultation')->findByStatus(Consultation::STATUS_COMPLETED);
            } break;
            default : {
                $consultations = Consultation::getMapper('Consultation')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['consultations'] = $consultations;
        $data['page-title'] = ucwords($status)." Consultations";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-consultations.php');
    }

    protected function AddConsultation(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'add-consultation';
        $data['page-title'] = "Add Consultation";
        $data['clinics'] = Clinic::getMapper('Clinic')->findByStatus(Clinic::STATUS_APPROVED);
        $data['doctors'] = Doctor::getMapper('Doctor')->findTypeByStatus(Doctor::UT_DOCTOR, Doctor::STATUS_ACTIVE);
        $data['patients'] = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_ACTIVE);

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/consultation-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processConsultationEditor($requestContext);
        }
    }

    protected function UpdateConsultation(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'update-consultation';
        $data['page-title'] = "Update Consultation";
        $data['clinics'] = Clinic::getMapper('Clinic')->findByStatus(Clinic::STATUS_APPROVED);
        $data['doctors'] = Doctor::getMapper('Doctor')->findTypeByStatus(Doctor::UT_DOCTOR, Doctor::STATUS_ACTIVE);
        $data['patients'] = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_ACTIVE);

        $consultation = $requestContext->fieldIsSet('consultation-id') ? Consultation::getMapper('Consultation')->find($requestContext->getField('consultation-id')) : null;
        $fields = array();
        if(is_object($consultation))
        {
            $fields['clinic'] = $consultation->getClinic()->getId();
            $fields['doctor'] = $consultation->getDoctor()->getId();
            $fields['patient'] = $consultation->getPatient()->getId();

            $fields['meeting-date']['month'] = $consultation->getMeetingDate()->getMonth();
            $fields['meeting-date']['day'] = $consultation->getMeetingDate()->getDay();
            $fields['meeting-date']['year'] = $consultation->getMeetingDate()->getYear();

            $fields['start-time']['hour'] = $consultation->getStartTime()->getHour();
            $fields['start-time']['minute'] = $consultation->getStartTime()->getMinute();
            $fields['start-time']['am_pm'] = $consultation->getStartTime()->getAmPm();

            $fields['end-time']['hour'] = $consultation->getEndTime()->getHour();
            $fields['end-time']['minute'] = $consultation->getEndTime()->getMinute();
            $fields['end-time']['am_pm'] = $consultation->getEndTime()->getAmPm();

            $data['consultation-id'] = $fields['consultation-id'] = $consultation->getId();
        }
        else{
            $requestContext->redirect(home_url("/".$requestContext->getRequestUrlParam(0)."/manage-consultations/",0));
        }
        $data['fields'] = $fields;

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/consultation-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processConsultationEditor($requestContext);
        }

    }

    private function processConsultationEditor(RequestContext $requestContext)
    {
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields();

        $clinic = Clinic::getMapper('Clinic')->find($fields['clinic']);
        $doctor = Doctor::getMapper("Doctor")->find($fields['doctor']);
        $patient = Patient::getMapper("Patient")->find($fields['patient']);
        $meeting_date = $fields['meeting-date'];
        $start_time = $fields['start-time'];
        $end_time = $fields['end-time'];

        preProcessTimeArr($start_time);
        preProcessTimeArr($end_time);

        $meeting_dateTime = new DateTime(mktime(0, 0, 0, $meeting_date['month'], $meeting_date['day'], $meeting_date['year']));
        $start_dateTime = new DateTime(mktime($start_time['hour'], $start_time['minute'], 0, $meeting_date['month'], $meeting_date['day'], $meeting_date['year']));
        $end_dateTime = new DateTime(mktime($end_time['hour'], $end_time['minute'], 0, $meeting_date['month'], $meeting_date['day'], $meeting_date['year']));

        if(
            is_object($doctor)
            and is_object($patient)
            and checkdate($meeting_date['month'], $meeting_date['day'], $meeting_date['year'])
            and DateTime::checktime($start_time['hour'], $start_time['minute'])
            and DateTime::checktime($end_time['hour'], $end_time['minute'])
            and $start_dateTime->getDateTimeInt() < $end_dateTime->getDateTimeInt()
        )
        {
            $consultation = $data['mode'] == 'add-consultation' ? new Consultation() : Consultation::getMapper('Consultation')->find($data['consultation-id']);
            if(is_object($consultation))
            {
                $consultation->setClinic($clinic);
                $consultation->setDoctor($doctor);
                $consultation->setPatient($patient);
                $consultation->setMeetingDate($meeting_dateTime);
                $consultation->setStartTime($start_dateTime);
                $consultation->setEndTime($end_dateTime);
                if($consultation->getId() == -1) $consultation->setStatus(Consultation::STATUS_BOOKED);

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'add-consultation' ? "Consultation booked successfully" : "Consultation updated successfully");

                $data['status'] = 1;
                $data['consultation-id'] = $consultation->getId();
                $data['mode'] = 'update-consultation';
                $data['fields'] = &$fields;
            }
        }
        else
        {
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }
}