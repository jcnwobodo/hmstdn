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
        return $this;
    }
}