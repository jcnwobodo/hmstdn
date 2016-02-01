<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/1/2016
 * Time:    11:24 AM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;

class Clinic extends DomainObject implements I_StatefulObject
{
    private $clinic_id;
    private $name;
    private $location_state;
    private $location_street;
    private $contact_email;
    private $contact_phone;
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getClinicId()
    {
        return $this->clinic_id;
    }

    /**
     * @param mixed $clinic_id
     * @return Clinic
     */
    public function setClinicId($clinic_id)
    {
        $this->clinic_id = $clinic_id;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Clinic
     */
    public function setName($name)
    {
        $this->name = $name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationState()
    {
        return $this->location_state;
    }

    /**
     * @param mixed $location_state
     * @return Clinic
     */
    public function setLocationState(Location $location_state)
    {
        $this->location_state = $location_state;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationStreet()
    {
        return $this->location_street;
    }

    /**
     * @param mixed $location_street
     * @return Clinic
     */
    public function setLocationStreet($location_street)
    {
        $this->location_street = $location_street;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }

    /**
     * @param mixed $contact_email
     * @return Clinic
     */
    public function setContactEmail($contact_email)
    {
        $this->contact_email = $contact_email;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->contact_phone;
    }

    /**
     * @param mixed $contact_phone
     * @return Clinic
     */
    public function setContactPhone($contact_phone)
    {
        $this->contact_phone = $contact_phone;
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
     * @return Clinic
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}