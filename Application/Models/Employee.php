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
    private $department;
    private $specialization;

    public function __construct($id)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     * @return Employee
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpecialization()
    {
        return $this->specialization;
    }

    /**
     * @param mixed $specialization
     * @return Employee
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
        return $this;
    }
}