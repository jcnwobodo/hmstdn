<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    1:15 PM
 **/

namespace Application\Models;


abstract class Employee extends User
{
    private $employment_data;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getEmploymentData()
    {
        if(!is_object($this->employment_data))
        {
            $emp_data_mapper = EmploymentData::getMapper('EmploymentData');
            $emp_data = $emp_data_mapper->find($this->getId());
            $this->employment_data = $emp_data;
        }
        return $this->employment_data;
    }

    /**
     * @param mixed $employment_data
     * @return Employee
     */
    public function setEmploymentData($employment_data)
    {
        $this->employment_data = $employment_data;
        $this->markDirty();
        return $this;
    }
}