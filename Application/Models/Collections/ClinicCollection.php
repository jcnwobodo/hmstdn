<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/1/2016
 * Time:    11:32 AM
 **/

namespace Application\Models\Collections;


class ClinicCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Clinic";
    }
}