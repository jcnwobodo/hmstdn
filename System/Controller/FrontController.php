<?php
namespace System\Controller;

use \Application\Config\ApplicationHelper;
use \System\Models\DomainObjectWatcher;
use \Application\Commands;
use \Application\Models;
use \System\Exceptions;
use \System\Request\RequestContext;

class FrontController
{
    private function __construct() {}

    public static function run() {
        $instance = new self();
        $instance->init();
        $instance->handleRequest();
    }

    public function init()
    {
        $applicationHelper = ApplicationHelper::instance();
        $applicationHelper->init();
    }

    public function handleRequest()
    {
        $requestContext = RequestContext::instance();
        $cmd_resolver = new CommandResolver();
        $this->r_run( $requestContext, $cmd_resolver);
        DomainObjectWatcher::instance()->performOperations();
    }

    private function r_run(RequestContext $requestContext, CommandResolver $cmd_resolver, $start=0)
    {
        //recursively run commands in a dynamic array
        $cmd_chain = $requestContext->getCommandChain();
        if(isset($cmd_chain[$start]))
        {
            $cmd_resolver->getCommand( $cmd_chain[$start] )->execute( $requestContext );
            $this->r_run($requestContext, $cmd_resolver, ++$start);
        }
    }
}