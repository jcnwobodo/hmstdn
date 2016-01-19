<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: ANPC.NET
 * Date:    1/8/2016
 * Time:    8:33 PM
 **/

namespace Application\Models\Collections;


class LocationCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Location";
    }
}