<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    5:14 PM
 */

namespace Application\Commands;

use Application\Models\Disease;
use Application\Models\Employee;
use Application\Models\EmploymentData;
use Application\Models\PersonalInfo;
use Application\Models\User;
use Application\Models\Location;
use Application\Models\LabTest;
use Application\Models\Upload;
use Application\Models\Clinic;
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
        $data = array();

        $data['page-title'] = "Admin Dashboard";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/dashboard.php');
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
        $types = array('admin', 'doctor', 'lab_technician', 'receptionist');
        $type = ( $requestContext->fieldIsSet('type') && in_array($requestContext->getField('type'), $types)) ? $requestContext->getField('type') : 'doctor';
        $data['type'] = $type;
        $data['clinics'] = Clinic::getMapper('Clinic')->findByStatus(Clinic::STATUS_APPROVED);

        if($requestContext->fieldIsSet("add"))
        {
            $data['status'] = false;
            $fields = $requestContext->getAllFields();

            $first_name = $fields['first-name'];
            $last_name = $fields['last-name'];
            $other_names = $fields['other-names'];
            $gender = $fields['gender'];
            /*
            $dob = $fields['date-of-birth'];
            $nationality = $fields['nationality'];
            $state_of_origin = $fields['state-of-origin'];
            $lga_of_origin = $fields['lga-of-origin'];
            $res_country = $fields['residence-country'];
            $res_state = $fields['residence-state'];
            $res_city = $fields['residence-city'];
            $res_street = $fields['residence-street'];
            */
            $contact_email = $fields['contact-email'];
            $contact_phone = $fields['contact-phone'];
            /*
            $passport = !empty($_FILES['passport-photo']) ? $requestContext->getFile('passport-photo') : null;
            */
            $clinic = Clinic::getMapper('Clinic')->find($fields['clinic']);
            $department = $fields['department'];
            $specialization = $fields['specialization'];
            $employee_id = $fields['employee-id'];
            $password1 = $fields['password1'];
            $password2 = $fields['password2'];

            //$date_is_correct = checkdate($dob['month'], $dob['day'], $dob['year']);
            /*Ensure that mandatory data is supplied, then create a report object*/
            if(
                strlen($first_name)
                and strlen($last_name)
                and in_array(strtolower($gender),PersonalInfo::$gender_enum)
                //and $date_is_correct
                //and strlen($nationality)
                //and strlen($state_of_origin)
                //and strlen($lga_of_origin)
                //and strlen($res_country)
                //and strlen($res_state)
                //and strlen($res_city)
                //and strlen($res_street)
                //and strlen($contact_email)
                and (strlen($contact_phone)==11)
                //and !is_null($passport)
                and is_object($clinic)
                and strlen($department)
                and strlen($specialization)
                and strlen($employee_id)
                and strlen($password1) and $password1 === $password2
            )
            {
                //$date_of_birth = new DateTime(mktime(0,0,0,$dob['month'],$dob['day'],$dob['year']));

                /*
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
                */

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
                    /*
                    if($photo_handled) $profile->setProfilePhoto($photo);
                    */
                    $profile->setFirstName($first_name);
                    $profile->setLastName($last_name);
                    $profile->setOtherNames($other_names);
                    $profile->setGender($gender);
                    /*
                    $profile->setDateOfBirth($date_of_birth);
                    $profile->setNationality($nationality);
                    $profile->setStateOfOrigin($state_of_origin);
                    $profile->setLga($lga_of_origin);
                    $profile->setResidenceCountry($res_country);
                    $profile->setResidenceState($res_state);
                    $profile->setResidenceCity($res_city);
                    $profile->setResidenceStreet($res_street);
                    */
                    $profile->setEmail(strtolower($contact_email));
                    $profile->setPhone($contact_phone);

                    $emp_data = new EmploymentData();
                    $emp_data->setId($user->getId());
                    $emp_data->setClinic($clinic);
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
                //if(!$date_is_correct) $requestContext->setFlashData("Please supply a valid date for date of birth");
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

    //Clinics management
    protected function ManageClinics(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'approved';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $clinic_ids = $requestContext->fieldIsSet('clinic-ids') ? $requestContext->getField('clinic-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($clinic_ids as $clinic_id)
                {
                    $clinic_obj = Clinic::getMapper('Clinic')->find($clinic_id);
                    if(is_object($clinic_obj)) $clinic_obj->setStatus(Clinic::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($clinic_ids as $clinic_id)
                {
                    $clinic_obj = Clinic::getMapper('Clinic')->find($clinic_id);
                    if(is_object($clinic_obj)) $clinic_obj->setStatus(Clinic::STATUS_APPROVED);
                }
            } break;
            case 'delete permanently' : {
                foreach($clinic_ids as $clinic_id)
                {
                    $clinic_obj = Clinic::getMapper('Clinic')->find($clinic_id);
                    if(is_object($clinic_obj))
                    {
                        $employees = EmploymentData::getMapper('EmploymentData')->findByClinic($clinic_obj);
                        if($employees->size()==0) $clinic_obj->markDelete();
                    }
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'approved' : {
                $clinics = Clinic::getMapper('Clinic')->findByStatus(Clinic::STATUS_APPROVED);
            } break;
            case 'deleted' : {
                $clinics = Clinic::getMapper('Clinic')->findByStatus(Clinic::STATUS_DELETED);
            } break;
            default : {
                $clinics = Clinic::getMapper('Clinic')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['clinics'] = $clinics;
        $data['page-title'] = ucwords($status)." Clinics";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-clinics.php');
    }

    protected function AddClinic(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'add-clinic';
        $data['location-states'] = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);
        $data['page-title'] = "Add Clinic";

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/clinic-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processClinicEditor($requestContext);
        }
    }

    protected function UpdateClinic(RequestContext $requestContext)
    {
        $data = array();

        $data['mode'] = 'update-clinic';
        $data['page-title'] = "Update Clinic";
        $data['location-states'] = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);

        $clinic = $requestContext->fieldIsSet('cid') ? Clinic::getMapper('Clinic')->find($requestContext->getField('cid')) : null;
        $fields = array();
        if(is_object($clinic))
        {
            $fields['clinic-name'] = $clinic->getName();
            $fields['clinic-id'] = $clinic->getClinicId();
            $fields['location-state'] = $clinic->getLocationState()->getId();
            $fields['location-street'] = $clinic->getLocationStreet();
            $fields['contact-email'] = $clinic->getContactEmail();
            $fields['contact-phone'] = $clinic->getContactPhone();

            $data['cid'] = $fields['cid'] = $clinic->getId();
        }
        else{
            $requestContext->redirect(home_url("/".$requestContext->getRequestUrlParam(0)."/manage-clinics/",0));
        }
        $data['fields'] = $fields;

        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/clinic-editor.php');

        if($requestContext->fieldIsSet($data['mode']))
        {
            $this->processClinicEditor($requestContext);
        }

    }

    private function processClinicEditor(RequestContext $requestContext)
    {
        $data = $requestContext->getResponseData();
        $fields = $requestContext->getAllFields();

        $clinic_name = $fields['clinic-name'];
        $clinic_id = $fields['clinic-id'];
        $location_state = Location::getMapper("Location")->find($fields['location-state']);
        $location_street = $fields['location-street'];
        $contact_email = strtolower($fields['contact-email']);
        $contact_phone = $fields['contact-phone'];

        $possible_clinic = Clinic::getMapper('Clinic')->findByClinicId($clinic_id);
        if(
            strlen($clinic_name)
            and strlen($clinic_id)
            and is_object($location_state)
            and strlen($location_street)
            and strlen($contact_phone) == 11
            and !(is_object($possible_clinic) and $data['mode']=='add-clinic')
        )
        {
            $clinic = $data['mode'] == 'add-clinic' ? new Clinic() : Clinic::getMapper('Clinic')->find($data['cid']);
            if(is_object($clinic))
            {
                $clinic->setName($clinic_name);
                $clinic->setClinicId($clinic_id);
                $clinic->setLocationState($location_state);
                $clinic->setLocationStreet($location_street);
                $clinic->setContactEmail($contact_email);
                $clinic->setContactPhone($contact_phone);
                if($clinic->getId() == -1) $clinic->setStatus(Clinic::STATUS_APPROVED);

                DomainObjectWatcher::instance()->performOperations();
                $requestContext->setFlashData($data['mode'] == 'add-clinic' ? "Clinic added successfully" : "Clinic details updated successfully");

                $data['status'] = 1;
                $data['cid'] = $clinic->getId();
                $data['mode'] = 'update-clinic';
                $data['fields'] = &$fields;
            }
        }
        else
        {
            $requestContext->setFlashData('Mandatory field(s) not set or invalid input detected');
            if((is_object($possible_clinic) and $data['mode']=='add-clinic')) $requestContext->setFlashData("Clinic ID must be unique");
            $data['status'] = 0;
        }
        $requestContext->setResponseData($data);
    }

    //LabTest Management
    protected function ManageTestRecords(RequestContext $requestContext)
    {
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'pending';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $test_ids = $requestContext->fieldIsSet('test-ids') ? $requestContext->getField('test-ids') : array();

        switch(strtolower($action))
        {
            case 'delete' : {
                foreach($test_ids as $test_id)
                {
                    $test_obj = LabTest::getMapper('LabTest')->find($test_id);
                    if(is_object($test_obj)) $test_obj->setStatus(LabTest::STATUS_DELETED);
                }
            } break;
            case 'restore' : {
                foreach($test_ids as $test_id)
                {
                    $test_obj = LabTest::getMapper('LabTest')->find($test_id);
                    if(is_object($test_obj))
                        $test_obj->setStatus( ( $test_obj->getResult()!=NULL) ? LabTest::STATUS_COMPLETED : LabTest::STATUS_PENDING );
                }
            } break;
            case 'delete permanently' : {
                foreach($test_ids as $test_id)
                {
                    $test_obj = LabTest::getMapper('LabTest')->find($test_id);
                    if(is_object($test_obj)) $test_obj->markDelete();
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'completed' : {
                $tests = LabTest::getMapper('LabTest')->findByStatus(LabTest::STATUS_APPROVED);
            } break;
            case 'pending' : {
                $tests = LabTest::getMapper('LabTest')->findByStatus(LabTest::STATUS_PENDING);
            } break;
            case 'deleted' : {
                $tests = LabTest::getMapper('LabTest')->findByStatus(LabTest::STATUS_DELETED);
            } break;
            default : {
                $tests = LabTest::getMapper('LabTest')->findAll();
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['tests'] = $tests;
        $data['page-title'] = ucwords($status)." Lab. Tests";
        $requestContext->setResponseData($data);
        $requestContext->setView('admin-area/manage-lab-tests.php');
    }
}