<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:35 PM
 */

namespace Application\Models\Collections;


class PersonalInfoCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\PersonalInfo";
    }
}