<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    12:01 PM
 **/

namespace Application\Models\Mappers;


class DoctorMapper extends EmployeeMapper
{
    protected function targetClass()
    {
        return "Application\\Models\\Doctor";
    }
}