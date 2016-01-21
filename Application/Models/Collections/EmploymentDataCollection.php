<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/21/2016
 * Time:    10:04 PM
 **/

namespace Application\Models\Collections;


class EmploymentDataCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\EmploymentData";
    }
}