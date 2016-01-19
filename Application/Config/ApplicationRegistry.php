<?php
namespace Application\Config;

class ApplicationRegistry
{
    static private $instance;
    static private $dsn = "mysql:dbname=www_rbhcistd;host=localhost";
    static private $db_user = "root";
    static private $db_user_password = "";

    private function __construct(){}

    static function instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    static function getDSN()
    {
        return self::$dsn;
    }

    static function getDbUser()
    {
        return self::$db_user;
    }

    static function getDbUserPassword()
    {
        return self::$db_user_password;
    }
} 