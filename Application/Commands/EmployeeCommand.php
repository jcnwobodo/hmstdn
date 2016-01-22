<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    7:20 PM
 **/

namespace Application\Commands;


use Application\Models\User;
use System\Request\RequestContext;

abstract class EmployeeCommand extends SecureCommand
{
    public function execute(RequestContext $requestContext)
    {
        $employee_types = array(User::UT_ADMIN,User::UT_DOCTOR,User::UT_LAB_TECH,User::UT_RECEPTIONIST);
        if($this->securityPass($requestContext, $employee_types, 'admin-area'))
        {
            parent::execute($requestContext);
        }
    }

}