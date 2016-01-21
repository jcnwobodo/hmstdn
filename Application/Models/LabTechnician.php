<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    9:20 AM
 **/

namespace Application\Models;


class LabTechnician extends Employee
{
    public function __construct($id=null)
    {
        parent::__construct($id);
        $this->setUserType(self::UT_LAB_TECH);
    }
}