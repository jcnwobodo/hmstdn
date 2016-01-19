<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: ANPC.NET
 * Date:    1/8/2016
 * Time:    8:51 PM
 **/

namespace Application\Models\Collections;


class UserMetaCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\UserMeta";
    }
}