<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    10:04 AM
 **/

namespace Application\Commands;


use Application\Models\User;
use Application\Models\LabTest;
use System\Request\RequestContext;
use System\Models\DomainObjectWatcher;
use System\Utilities\DateTime;

abstract class DoctorAndLabTechnicianCommand extends EmployeeCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, array(User::UT_DOCTOR, User::UT_LAB_TECH), 'doctor-area'))
        {
            parent::execute($requestContext);
        }
    }

    //LabTest Management
    protected function LabTestRecords(RequestContext $requestContext)
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
            case 'mark as positive' :
            case 'mark as negative' : {
                foreach($test_ids as $test_id)
                {
                    $test_obj = LabTest::getMapper('LabTest')->find($test_id);
                    if(is_object($test_obj)){
                        $test_obj->setStatus(LabTest::STATUS_COMPLETED);
                        $test_obj->setResult( (strtolower($action)=='mark as positive' ? 1 : 0) );
                        $test_obj->setOperator($requestContext->getSession()->getSessionUser());
                        $test_obj->setTestDate(new DateTime());
                    }
                }
            } break;
            case 'restore' : {
                foreach($test_ids as $test_id)
                {
                    $test_obj = LabTest::getMapper('LabTest')->find($test_id);
                    if(is_object($test_obj)) $test_obj->setStatus(LabTest::STATUS_PENDING);
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
        $requestContext->setView('manage-lab-tests.php');
    }
}