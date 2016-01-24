<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    2:57 PM
 **/

namespace Application\Commands;


use System\Request\RequestContext;
use System\Auth\AccessManager;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;
use Application\Models\User;
use Application\Models\PersonalInfo;
use Application\Models\Researcher;
use Application\Models\Upload;

class RegisterCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $possible_session = $requestContext->getSession();
        if(! is_null($possible_session))
        {
            $redirect_url = home_url( '/'.User::getDefaultCommand($possible_session->getUserType()), false );
            $requestContext->redirect($redirect_url);
        }

        if($requestContext->fieldIsSet('register'))
        {
            $this->doRegister($requestContext);
        }
        $data = is_array($requestContext->getResponseData()) ? $requestContext->getResponseData() : array();
        $data['page-title'] = "Researcher Registration Form";
        $requestContext->setView('researcher-register.php');
    }

    private function doRegister(RequestContext $requestContext)
    {
        $data = array();

        if($requestContext->fieldIsSet("register"))
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
            $researcher_id = $fields['researcher-id'];
            $password1 = $fields['password1'];
            $password2 = $fields['password2'];

            $date_is_correct = checkdate($dob['month'], $dob['day'], $dob['year']);
            /*Ensure that mandatory data is supplied, then create a report object*/
            if(
                strlen($first_name)
                and strlen($last_name)
                and in_array(strtolower($gender),PersonalInfo::$gender_enum)
                and $date_is_correct
                and strlen($nationality)
                and strlen($state_of_origin)
                and strlen($lga_of_origin)
                and strlen($res_country)
                and strlen($res_state)
                and strlen($res_city)
                and strlen($res_street)
                and strlen($contact_email)
                and (strlen($contact_phone)==11)
                and !is_null($passport)
                and strlen($researcher_id)
                and strlen($password1) and $password1 === $password2
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

                if($photo_handled)
                {
                    $user = new Researcher();
                    $user->setUsername(strtolower($researcher_id));
                    $user->setPassword($password1);
                    $user->setUserType(User::UT_RESEARCHER);
                    $user->setStatus($user::STATUS_ACTIVE);
                    $user->mapper()->insert($user);

                    $profile = new PersonalInfo();
                    $profile->setId($user->getId());
                    $profile->setProfilePhoto($photo);
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

                    $requestContext->setFlashData("Researcher registration completed successfully.");
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

        $data['page-title'] = "Researcher Registration Form";
        $requestContext->setResponseData($data);
    }
}