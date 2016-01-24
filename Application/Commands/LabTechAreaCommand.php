<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    4:13 PM
 **/

namespace Application\Commands;


use Application\Models\User;
use System\Request\RequestContext;
use System\Models\DomainObjectWatcher;

class LabTechAreaCommand extends DoctorAndLabTechnicianCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, User::UT_LAB_TECH, 'lab-tech-area'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();

        $data['page-title'] = "Lab. Centre";
        $requestContext->setResponseData($data);
        $requestContext->setView('lab-center/dashboard.php');
    }

}