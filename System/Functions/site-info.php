<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/23/2015
 * Time:    3:11 PM
 */

function site_info($index, $show = true)
{
    global $site_info;
    $return_value = null;
    if(isset($site_info[$index])){$return_value = $site_info[$index];}
    if($show){ echo $return_value;} else {return $return_value; }
}

function home_url($appendage='', $show = true)
{
    $return_value = site_info('site_url', false).$appendage;
    if($show){ echo $return_value;} else {return $return_value; }
}

function stylesheet_url($show = true)
{
    $return_value = site_info('site_url', false)."/".site_info('stylesheet_url', false);
    if($show){ echo $return_value;} else {return $return_value; }
}

function is_development()
{
    return (!is_null(site_info('development_mode', false)) ? site_info('development_mode', false) : true);
}