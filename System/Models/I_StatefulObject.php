<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: ANPC.NET
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models;


interface I_StatefulObject
{
    const STATUS_PENDING = 2;
    const STATUS_APPROVED = 1;
    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const STATUS_CANCELED = 0;
    const STATUS_BOOKED = 2;
    const STATUS_COMPLETED = 1;

    function getStatus();
    function setStatus($status);
}