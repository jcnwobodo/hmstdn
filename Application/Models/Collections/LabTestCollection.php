<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    11:21 AM
 **/

namespace Application\Models\Collections;


class LabTestCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\LabTest";
    }
}