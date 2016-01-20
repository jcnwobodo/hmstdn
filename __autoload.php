<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    11:04 PM
 */

$__autoload = array(
    "Application/Config/config.php",
    "System/Functions/site-info.php",
    "System/Functions/functions-lib.php",
    "System/Functions/form-elements.php"
);

foreach($__autoload as $file)
{
    if(is_file($file))
    {
        require_once($file);
    }
    else
    {
        echo "<br/>File '".$file."' not found" ;
        exit;
    }
}

function __autoload( $path )
{
    if ( preg_match( '/\\\\/', $path ) )
    {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path );
        $path .= ".php";
    }
    if(!is_file($path))
    {
        echo "<br/>File (<b>$path</b>) not found" ;
        exit;
    }
    require_once($path);
}