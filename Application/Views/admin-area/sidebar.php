<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/2/2016
 * Time:    8:00 AM
 **/

$rc = \System\Request\RequestContext::instance();
$user_type  = $rc->getSession()->getUserType();

if($user_type=='Receptionist')
{
    include_once("Application/Views/reception-room/sidebar.php");
}
if($user_type=='Admin')
{
    include_once("Application/Views/admin-area/admin-sidebar.php");
}