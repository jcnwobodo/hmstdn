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
    <link href="<?php home_url('/Assets/css/style.css'); ?>" type="text/css" rel="stylesheet">
</head>

<body>

<!-- Fixed Top navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php home_url('')?>"><?php site_info('name'); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="<?= ($rc->isRequestUrl('conference') ? 'active': ''); ?> dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Conference Center<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">General Assembly</a></li>
                        <li><a href="#">Current Issues</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="<?= ($rc->isRequestUrl('') ? 'active': ''); ?> dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">People's Parliament <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
<!--                        <li><a href="#">Current Issues</a></li>-->
                            <li><a href="<?php home_url('/poll')?>">Polls</a></li>
                        <li><a href="#">Resolutions</a></li>
                    </ul>
                </li>
                
                <!--<li <?//= $s = ($rc->isRequestUrl('news') ? 'class="active"': ''); ?>><a href="#">News</a></li>-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?php home_url('/login') ?>">Login/Register</a></li>
                <!--<li><a href="#">Register</a></li>-->
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid" id="container-main">
