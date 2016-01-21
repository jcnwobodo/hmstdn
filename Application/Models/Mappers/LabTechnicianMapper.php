<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    12:02 PM
 **/

namespace Application\Models\Mappers;


class LabTechnicianMapper extends EmployeeMapper
{
    protected function targetClass()
    {
        return "Application\\Models\\LabTechnician";
    }
}