<?php
namespace Application\Models\Collections;

class UserCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\User";
    }
}