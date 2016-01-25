<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    7:29 PM
 **/

namespace Application\Commands;


use Application\Models\User;
use Application\Models\Patient;
use Application\Models\Doctor;
use Application\Models\PersonalInfo;
use Application\Models\Consultation;
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
                        $patient_obj->getPersonalInfo()->markDelete();
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

            $date_is_correct = checkdate($dob['month'], $dob['day'], $dob['year']);
            $card_number_is_unique = is_null(Patient::getMapper('Patient')->findByCardNumber($card_number));
            /*Ensure that mandatory data is supplied, then create a report object*/
            if(
                is_numeric($card_number) and strlen($card_number)==6 and $card_number_is_unique
                and strlen($blood_group)
                and strlen($genotype)
                and strlen($first_name)
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
            )
            {
                $date_of_birth = new DateTime(mktime(0,0,0,$dob['month'],$dob['day'],$dob['year']));

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
                //if(!$date_is_correct) $requestContext->setFlashData("Please supply a valid date for date of birth");
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
        $data['doctors'] = Doctor::getMapper('Doctor')->findTypeByStatus(Doctor::UT_DOCTOR, Doctor::STATUS_ACTIVE);
        $data['patients'] = Patient::getMapper('Patient')->findByStatus(Patient::STATUS_ACTIVE);

        $consultation = $requestContext->fieldIsSet('consultation-id') ? Consultation::getMapper('Consultation')->find($requestContext->getField('consultation-id')) : null;
        $fields = array();
        if(is_object($consultation))
        {
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