<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    11/1/2015
 * Time:    10:33 PM
 */

namespace Application\Models\Mappers;

use \System\Models\Mappers\Mapper as SystemMapper;

abstract class Mapper extends SystemMapper
{
    public function __construct()
    {
        parent::__construct();
    }
}