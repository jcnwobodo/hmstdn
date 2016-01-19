<?php
namespace System\Controller;

use System\Exceptions;

class CommandResolver
{
    private static $dir = "Application\\Commands";
    static function getCommand( $action='Default' )
    {
        if ( preg_match( '/\W-/', $action ) )
        {
            throw new \Exception("illegal characters in action");
        }
        $action = strlen($action) ? $action : 'Default';
        $class_name = str_replace(' ','',ucwords( strtolower( str_replace('-',' ',$action) ) ) ).'Command';
        $file = (!empty(self::$dir)) ? self::$dir."\\".$class_name.'.php' : $class_name.'.php';
        if ( ! file_exists( $file ) )
        {
            throw new Exceptions\CommandNotFoundException( "<br/>Can not find file ($file)" );
        }
        $class = self::$dir."\\{$class_name}";
        if ( ! class_exists( $class ) or $class_name=='SecureCommand')
        {
            throw new Exceptions\CommandNotFoundException( "<br/>Can not find class: $class" );
        }
        $cmd = new $class();
        return $cmd;
    }
}