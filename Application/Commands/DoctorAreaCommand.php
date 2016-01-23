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

}