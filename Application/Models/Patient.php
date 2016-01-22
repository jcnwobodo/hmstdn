<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/20/2016
 * Time:    11:31 PM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;

class Patient extends DomainObject implements I_StatefulObject
{
    private $card_number;
    private $blood_group;
    private $genotype;
    private $personal_info;
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getCardNumber()
    {
        return $this->card_number;
    }

    /**
     * @param mixed $card_number
     * @return Patient
     */
    public function setCardNumber($card_number)
    {
        $this->card_number = $card_number;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBloodGroup()
    {
        return $this->blood_group;
    }

    /**
     * @param mixed $blood_group
     * @return Patient
     */
    public function setBloodGroup($blood_group)
    {
        $this->blood_group = $blood_group;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenotype()
    {
        return $this->genotype;
    }

    /**
     * @param mixed $genotype
     * @return Patient
     */
    public function setGenotype($genotype)
    {
        $this->genotype = $genotype;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPersonalInfo()
    {
        return $this->personal_info;
    }

    /**
     * @param mixed $personal_info
     * @return Patient
     */
    public function setPersonalInfo(PersonalInfo $personal_info)
    {
        $this->personal_info = $personal_info;
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
     * @return Patient
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}