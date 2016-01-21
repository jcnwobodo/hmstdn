<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:17 PM
 */

namespace Application\Models\Mappers;

class AdminMapper extends EmployeeMapper
{
    protected function targetClass()
    {
        return "Application\\Models\\Admin";
    }
}