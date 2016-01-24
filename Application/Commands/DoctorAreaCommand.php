<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    3:49 AM
 **/

namespace Application\Commands;

use Application\Models\Disease;
use Application\Models\LabTest;
use Application\Models\Location;
use Application\Models\User;
use System\Utilities\DateTime;
use Application\Models\Consultation;
use System\Request\RequestContext;
use System\Models\DomainObjectWatcher;

class DoctorAreaCommand extends DoctorAndLabTechnicianCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, User::UT_DOCTOR, 'doctor-area'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();

        $data['page-title'] = "Doctor Dashboard";
        $requestContext->setResponseData($data);
        $requestContext->setView('doctor-area/dashboard.php');
    }

    //Consultations management
    protected function ManageConsultations(RequestContext $requestContext)
    {
        $doctor = $requestContext->getSession()->getSessionUser();
        $status = $requestContext->fieldIsSet('status') ? $requestContext->getField('status') : 'booked';
        $action = $requestContext->fieldIsSet('action') ? $requestContext->getField('action') : null;
        $consultation_ids = $requestContext->fieldIsSet('consultation-ids') ? $requestContext->getField('consultation-ids') : array();

        switch(strtolower($action))
        {
            case 'mark as completed' : {
                foreach($consultation_ids as $consultation_id)
                {
                    $consultation_obj = Consultation::getMapper('Consultation')->find($consultation_id);
                    if(is_object($consultation_obj)) $consultation_obj->setStatus(Consultation::STATUS_COMPLETED);
                }
            } break;
            default : {}
        }
        DomainObjectWatcher::instance()->performOperations();

        switch($status)
        {
            case 'booked' : {
                $consultations = Consultation::getMapper('Consultation')->findByDoctorAndStatus($doctor->getId(), Consultation::STATUS_BOOKED);
            } break;
            case 'canceled' : {
                $consultations = Consultation::getMapper('Consultation')->findByDoctorAndStatus($doctor->getId(), Consultation::STATUS_CANCELED);
            } break;
            case 'completed' : {
                $consultations = Consultation::getMapper('Consultation')->findByDoctorAndStatus($doctor->getId(), Consultation::STATUS_COMPLETED);
            } break;
            default : {
                $consultations = Consultation::getMapper('Consultation')->findByDoctor($doctor->getId());
            }
        }

        $data = array();
        $data['status'] = $status;
        $data['consultations'] = $consultations;
        $data['page-title'] = ucwords($status)." Consultations";
        $requestContext->setResponseData($data);
        $requestContext->setView('doctor-area/manage-consultations.php');
    }

    protected function ConsultationInfo(RequestContext $requestContext)
    {
        if($requestContext->fieldIsSet('cid'))
        {
            $consultation = Consultation::getMapper('Consultation')->find($requestContext->getField('cid'));
            if(is_object($consultation))
            {
                $status = false;
                $fields = array(
                    'notes' => $consultation->getNotes(),
                    'diagnoses' => $consultation->getDiagnoses(),
                    'treatment' => $consultation->getTreatment()
                );
                if($requestContext->fieldIsSet('update'))
                {
                    $notes = $requestContext->getField('notes');
                    $diagnoses = $requestContext->getField('diagnoses');
                    $treatment = $requestContext->getField('treatment');

                    $fields = array(
                        'notes' => $notes,
                        'diagnoses' => $diagnoses,
                        'treatment' => $treatment
                    );

                    if(strlen($notes) and strlen($diagnoses))
                    {
                        $consultation->setNotes($notes);
                        $consultation->setDiagnoses($diagnoses);
                        $consultation->setTreatment($treatment);

                        $status = true;
                        $requestContext->setFlashData("Consultation updated successfully");
                    }
                    else
                    {
                        $status = false;
                        $requestContext->setFlashData("Consultation updated successfully");
                    }
                }

                $data = array();
                $data['status'] = $status;
                $data['consultation'] = $consultation;
                $data['fields'] = $fields;
                $data['page-title'] = "Consultation Info.";
                $requestContext->setResponseData($data);
                $requestContext->setView('doctor-area/consultation-info.php');
                return;
            }
        }
        $requestContext->redirect(home_url('/doctor-area/manage-consultations/',0));
    }

    //LabTest Management
    protected function RequestLabTest(RequestContext $requestContext)
    {
        $data = array();
        $doctor = $requestContext->getSession()->getSessionUser();
        $data['consultations'] = Consultation::getMapper('Consultation')->findByDoctorAndStatus($doctor->getId(), Consultation::STATUS_BOOKED);
        $data['diseases'] = Disease::getMapper('Disease')->findByStatus(Disease::STATUS_APPROVED);
        $data['locations'] = Location::getMapper('Location')->findTypeByStatus(Location::TYPE_STATE, Location::STATUS_APPROVED);

        if($requestContext->fieldIsSet('request'))
        {
            $fields = $requestContext->getAllFields();

            //process request
            $consultation = Consultation::getMapper('Consultation')->find($fields['consultation']);
            $disease = Disease::getMapper('Disease')->find($fields['disease']);
            $request_date = new DateTime();
            $patient_location = Location::getMapper('Location')->find($fields['location']);

            if(is_object($consultation) and is_object($disease))
            {
                $test = new LabTest();
                $test->setConsultation($consultation);
                $test->setDisease($disease);
                $test->setRequestDate($request_date);
                $test->setPatientLocation($patient_location);
                $test->setStatus(LabTest::STATUS_PENDING);

                $requestContext->setFlashData("Lab. Test request placed successfully");
                $data['status'] = 1;
            }
            else
            {
                $requestContext->setFlashData('Mandatory fields not set');
                $data['status'] = 0;
            }
            DomainObjectWatcher::instance()->performOperations();
        }

        $data['page-title'] = "Request Lab. Test";
        $requestContext->setResponseData($data);
        $requestContext->setView('doctor-area/lab-test-request-form.php');
    }
}