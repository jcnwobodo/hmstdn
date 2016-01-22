<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/21/2016
 * Time:    10:01 PM
 **/

namespace Application\Models;


class EmploymentData extends DomainObject
{
    private $department;
    private $specialization;

    public function __construct($id=null)
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
     * @return EmploymentData
     */
    public function setDepartment($department)
    {
        $this->department = $department;
        $this->markDirty();
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
     * @return EmploymentData
     */
    public function setSpecialization($specialization)
    {
        $this->specialization = $specialization;
        $this->markDirty();
        return $this;
    }
}