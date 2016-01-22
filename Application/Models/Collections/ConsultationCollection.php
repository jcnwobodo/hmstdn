<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    9:11 AM
 **/

namespace Application\Models\Collections;


class ConsultationCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Consultation";
    }
}