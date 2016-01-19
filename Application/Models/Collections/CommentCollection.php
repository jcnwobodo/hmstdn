<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackmarket
 * Date:    11/16/2015
 * Time:    10:52 PM
 */

namespace Application\Models\Collections;


class CommentCollection extends Collection
{
    public function targetClass()
    {
        return "Application\\Models\\Comment";
    }
}