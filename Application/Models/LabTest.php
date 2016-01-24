<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    11:12 AM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class LabTest extends DomainObject implements I_StatefulObject
{
    private $consultation;
    private $operator;
    private $disease;
    private $request_date;
    private $test_date;
    private $patient_location;
    private $result;
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getConsultation()
    {
        return $this->consultation;
    }

    /**
     * @param mixed $consultation
     * @return LabTest
     */
    public function setConsultation(Consultation $consultation)
    {
        $this->consultation = $consultation;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     * @return LabTest
     */
    public function setOperator(LabTechnician $operator)
    {
        $this->operator = $operator;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisease()
    {
        return $this->disease;
    }

    /**
     * @param mixed $disease
     * @return LabTest
     */
    public function setDisease(Disease $disease)
    {
        $this->disease = $disease;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestDate()
    {
        return $this->request_date;
    }

    /**
     * @param mixed $request_date
     * @return LabTest
     */
    public function setRequestDate(DateTime $request_date)
    {
        $this->request_date = $request_date;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestDate()
    {
        return $this->test_date;
    }

    /**
     * @param mixed $test_date
     * @return LabTest
     */
    public function setTestDate(DateTime $test_date)
    {
        $this->test_date = $test_date;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatientLocation()
    {
        return $this->patient_location;
    }

    /**
     * @param mixed $patient_location
     * @return LabTest
     */
    public function setPatientLocation(Location $patient_location)
    {
        $this->patient_location = $patient_location;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return LabTest
     */
    public function setResult($result)
    {
        $this->result = $result;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return LabTest
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}