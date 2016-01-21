<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    9:24 AM
 **/

namespace Application\Models;


class Researcher extends User
{
    public function __construct($id=null)
    {
        parent::__construct($id);
        $this->setUserType(self::UT_RESEARCHER);
    }
}