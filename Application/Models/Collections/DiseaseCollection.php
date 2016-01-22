<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    6:03 PM
 **/

namespace Application\Models\Collections;


class DiseaseCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Disease";
    }
}