<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/29/2015
 * Time:    1:06 PM
 **/

$requestContext = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
$page_title = isset($data['page-title']) ? $data['page-title'] : site_info('name',0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="J. C. Nwobodo">
    <link rel="icon" href="<?php home_url('/Assets/favicon.ico'); ?>">

    <title><?= $page_title; ?> -<?php site_info('name'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php home_url('/Assets/css/style.css'); ?>" type="text/css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php stylesheet_url(); ?>" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="<?php home_url('/Assets/css/dashboard.css'); ?>" type="text/css" rel="stylesheet">

</head>

<body>
<div class="bg-color2 height-100vh">
<nav class="navbar navbar-inverse bg-color1 navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php home_url('/'); ?>"><span class="glyphicon glyphicon-home"></span> <?= strtoupper(site_info('name',0)); ?></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li <?= $s = ($requestContext->isRequestUrl($requestContext->getSession()->getSessionUser()->defaultCommand()) ? 'class="active"': ''); ?>><a href="<?php home_url('/'.$requestContext->getRequestUrlParam(1).'/');?>"><span class="glyphicon glyphicon-dashboard"></span> DASHBOARD</a></li>
                <li <?= $s = ($requestContext->isRequestUrl('account-setting') ? 'class="active"': ''); ?>><a href="<?php home_url('/account-settings/');?>"><span class="glyphicon glyphicon-user"></span> MY ACCOUNT</a></li>
                <li <?= $s = ($requestContext->isRequestUrl('logout') ? 'class="active"': ''); ?>><a href="<?php home_url('/logout/');?>"><span class="glyphicon glyphicon-log-out"></span> LOGOUT</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid">
