<?php
$requestContext = $rc = \System\Request\RequestContext::instance();
$data = $requestContext->getResponseData();
$page_title = isset($data['page-title']) ? $data['page-title'] : site_info('name',0);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php site_info('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="J. C. Nwobodo">

    <title><?= $page_title; ?> - <?php site_info('name'); ?></title>
    <link rel="icon" href="<?php home_url('/Assets/favicon.ico'); ?>">

    <!-- Custom CSS and Bootstrap core CSS -->
    <link href="<?php stylesheet_url(); ?>" type="text/css" rel="stylesheet">
</head>

<body>
<div class="container-fluid" id="top">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1 class="mid-margin-bottom full-margin-top"><?php site_info('full-name'); ?></h1>
        </div>
    </div>
</div>

<!-- Fixed Top navbar -->
<nav class="navbar navbar-default navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?= ($rc->isRequestUrl('') ? 'class="active"': ''); ?>><a href="<?php home_url()?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li <?= ($rc->isRequestUrl('page/about') ? 'class="active"': ''); ?>><a href="<?php home_url('/page/about/')?>"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>
                <li <?= ($rc->isRequestUrl('stat-summary') ? 'class="active"': ''); ?>><a href="<?php home_url('/stat-summary/')?>"><span class="glyphicon glyphicon-flash"></span> Stat. Summaries</a></li>
                <li <?= ($rc->isRequestUrl('contact') ? 'class="active"': ''); ?>><a href="<?php home_url('/contact/')?>"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li <?= ($rc->isRequestUrl('login') ? 'class="active"': ''); ?>><a href="<?php home_url('/login/')?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li <?= ($rc->isRequestUrl('register') ? 'class="active"': ''); ?>><a href="<?php home_url('/register/')?>"><span class="glyphicon glyphicon-user"></span> Register</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid" id="container-main">
