<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    3:49 AM
 **/

namespace Application\Commands;


use Application\Models\User;
use System\Utilities\DateTime;
use Application\Models\Consultation;
use System\Request\RequestContext;
use System\Models\DomainObjectWatcher;

class DoctorAreaCommand extends EmployeeCommand
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
}