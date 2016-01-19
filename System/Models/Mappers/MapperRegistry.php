<?php
namespace System\Models\Mappers;

//caching mapper objects
class MapperRegistry
{
    static private $mapper_objects = array();

    static function getMapper($class_name)
    {
        if(!isset(self::$mapper_objects[$class_name]) or !is_object(self::$mapper_objects[$class_name]))
        {
            $arr = explode('\\', $class_name);
            $root_class_name = $arr[sizeof($arr)-1];
            $mapper_class_name = "Application\\Models\\Mappers\\{$root_class_name}Mapper";
            self::$mapper_objects[$class_name] = new $mapper_class_name();
        }
        return self::$mapper_objects[$class_name];
    }
} 