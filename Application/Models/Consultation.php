<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    9:01 AM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

class Consultation extends DomainObject implements I_StatefulObject
{
    private $doctor;
    private $patient;
    private $meeting_date;
    private $start_time;
    private $end_time;
    private $notes;
    private $diagnoses;
    private $treatment;
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * @param mixed $doctor
     * @return Consultation
     */
    public function setDoctor(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     * @return Consultation
     */
    public function setPatient(Patient $patient)
    {
        $this->patient = $patient;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeetingDate()
    {
        return $this->meeting_date;
    }

    /**
     * @param mixed $meeting_date
     * @return Consultation
     */
    public function setMeetingDate(DateTime $meeting_date)
    {
        $this->meeting_date = $meeting_date;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * @param mixed $start_time
     * @return Consultation
     */
    public function setStartTime(DateTime $start_time)
    {
        $this->start_time = $start_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * @param mixed $end_time
     * @return Consultation
     */
    public function setEndTime(DateTime $end_time)
    {
        $this->end_time = $end_time;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     * @return Consultation
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiagnoses()
    {
        return $this->diagnoses;
    }

    /**
     * @param mixed $diagnoses
     * @return Consultation
     */
    public function setDiagnoses($diagnoses)
    {
        $this->diagnoses = $diagnoses;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * @param mixed $treatment
     * @return Consultation
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;
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
     * @return Consultation
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}