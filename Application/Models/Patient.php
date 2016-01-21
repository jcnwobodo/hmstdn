<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    11:31 PM
 **/

namespace Application\Models;


class Patient extends DomainObject
{
    public function __construct($id=null)
    {
        parent::__construct($id);
    }
}