<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    9:26 PM
 */

namespace Application\Commands;

use System\Request\RequestContext;
use Application\Models\User;

abstract class SecureCommand extends Command
{
    protected function securityPass(RequestContext $requestContext, $allowed_user_types, $redirect_command)
    {
        $session = $requestContext->getSession();
        if(! is_null($session) and $session->userAuthorized($allowed_user_types))
        {
            return true;
        }
        elseif(! is_null($session) and !$session->userAuthorized($allowed_user_types))
        {
            $requestContext->redirect( home_url( '/'.User::getDefaultCommand($session->getUserType()).'/', false ) );
        }
        else
        {
            $requestContext->redirect( home_url('/login/?redirect='.home_url('/'.$redirect_command, false), false) );
        }
    }
}