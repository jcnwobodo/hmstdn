<?php
namespace Application\Config;

class ApplicationHelper
{
    private static $instance;
    private function __construct(){}

    static function instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //initialize Application
    function init()
    {

    }
}