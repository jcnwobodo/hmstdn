<?php
namespace Application\Commands;

use System\Request\RequestContext;
use System\Auth\AccessManager;

class LogoutCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $requestContext->setView('page-login.php');

        if(! is_null($requestContext->getSession()))
        {
            $manager = AccessManager::instance();
            $manager->logout($requestContext->getSession()->getSessionId());
            $redirect = $requestContext->fieldIsSet('redirect') ? $requestContext->getField('redirect') : home_url('/login/', false);
            $requestContext->redirect($redirect);
        }
    }
}