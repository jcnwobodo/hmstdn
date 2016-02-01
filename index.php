<?php
//Load Pre-run functions and classes
require("__autoload.php");

//Run Application
use \System\Controller\FrontController;
use \System\Exceptions;

$requestContext = \System\Request\RequestContext::instance();

try
{
    $request_url = $requestContext->getRequestUrl();
    if(is_file($request_url))
    {
        readfile($request_url);
        exit;
    }
    FrontController::run();
    $requestContext->invokeView();
}
catch (Exceptions\CommandNotFoundException $exception)
{
    $response  = $requestContext->getRequestUrl()."<br/>";
    $response .= $exception->getMessage()."<br/>";
    $data = array('page-title'=>'Page Not Found', 'error-message'=>$response);
    $requestContext->setResponseData($data);
    $requestContext->setView('404.php');
    $requestContext->invokeView();
}
catch (Exceptions\FormFieldNotFoundException $exception)
{
    print_r($exception->getMessage()."<br/>");
    print_r( implode( "<br/>", $exception->getTrace() ) );
}
catch (\PDOException $exception)
{
    ///*
    //development mode
    print_r($exception->getMessage()."<br/>");
    print_r( recursive_implode( "<br/>", $exception->getTrace() ) );
    //*/
}
catch (\Exception $exception)
{
    print_r($exception->getMessage()."<br/>");
    print_r( recursive_implode( "<br/>", $exception->getTrace() ) );
}