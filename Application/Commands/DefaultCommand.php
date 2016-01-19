<?php
namespace Application\Commands;

use System\Request\RequestContext;

class DefaultCommand extends Command
{
    protected function doExecute(RequestContext $requestContext)
    {
        $requestContext->setView('index.php');
    }
}