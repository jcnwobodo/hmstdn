<?php
namespace System\Models;

use Application\Models\Collections;
use System\Models\Mappers\MapperRegistry;

abstract class DomainObjectHelper
{
    static  function getCollection($type)
    {
        $class_name = "\\Collections\\".$type."Collection";
        return new $class_name();
    }

    static  function getMapper($class_name)
    {
        return MapperRegistry::getMapper($class_name);
    }
}