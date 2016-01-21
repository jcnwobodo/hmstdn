<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/21/2016
 * Time:    10:24 PM
 **/

namespace Application\Models\Mappers;


use Application\Models\EmploymentData;

class EmployeeMapper extends UserMapper
{
    protected function doCreateObject(array $array)
    {
        $object = parent::doCreateObject($array);
        $emp_data_mapper = EmploymentData::getMapper('EmploymentData');
        $emp_data = $emp_data_mapper->find($object->getId());
        $object->setEmploymentData($emp_data);

        return $object;
    }
}