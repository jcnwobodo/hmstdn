<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    9:23 AM
 **/

namespace Application\Models;


class Doctor extends User
{
    public function __construct($id)
    {
        parent::__construct($id);
        $this->setUserType(self::UT_DOCTOR);
    }
}