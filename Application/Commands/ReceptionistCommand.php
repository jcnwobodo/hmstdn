<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/2/2016
 * Time:    7:38 AM
 **/

namespace Application\Commands;


use Application\Models\User;
use System\Request\RequestContext;

class ReceptionistCommand extends AdminAndReceptionistCommand
{
    public function execute(RequestContext $requestContext)
    {
        if($this->securityPass($requestContext, User::UT_RECEPTIONIST, User::getDefaultCommand(User::UT_RECEPTIONIST)))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data = array();

        $data['page-title'] = "Reception Room";
        $data['current-user'] = $requestContext->getSession()->getSessionUser()->getPersonalInfo()->getNames();
        $requestContext->setResponseData($data);
        $requestContext->setView('reception-room/dashboard.php');
    }

}