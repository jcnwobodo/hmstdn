<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:28 PM
 */

namespace Application\Models\Collections;

class AdminCollection extends EmployeeCollection
{
    public function targetClass()
    {
        return "Application\\Models\\Admin";
    }
}