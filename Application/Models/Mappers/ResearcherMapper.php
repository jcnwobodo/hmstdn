<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/24/2016
 * Time:    3:23 PM
 **/

namespace Application\Models\Mappers;


class ResearcherMapper extends UserMapper
{
    protected function targetClass()
    {
        return "Application\\Models\\Researcher";
    }
}