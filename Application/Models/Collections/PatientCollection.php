<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    11:29 PM
 **/

namespace Application\Models\Collections;


class PatientCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Patient";
    }
}