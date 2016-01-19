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
        $requestUrl = $requestContext->getRequestUrl();
        $posts_mapper = Models\Post::getMapper("Post");

        //Check if link points to a specific post/page
        if(!empty($requestUrl))
        {
            $possible_post = $posts_mapper->findByPamalink($requestUrl);
            if(! is_null($possible_post) and $possible_post->isPublished())
            {
                $requestContext->resetCommandChain();
                $requestContext->addCommand('Posts');
                $requestContext->setResponseData($possible_post);
            }
        }

        //if none of the above conditions were met, requestContext sets commandChain[0] to 'DefaultCommand',
        //thus, the homepage is loaded
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