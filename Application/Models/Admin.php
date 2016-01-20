<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    1:12 PM
 */

namespace Application\Models;

class Admin extends Employee
{
    public function __construct($id=null)
    {
        parent::__construct($id);
        $this->setUserType(self::UT_ADMIN);
    }
}