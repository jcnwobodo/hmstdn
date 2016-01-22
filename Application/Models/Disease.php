<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    5:56 PM
 **/

namespace Application\Models;


use System\Models\I_StatefulObject;

class Disease extends DomainObject implements I_StatefulObject
{
    private $name;
    private $causative_organisms;
    private $signs_and_symptoms;
    private $status;

    public function __construct($id=null)
    {
        parent::__construct($id);
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
     * @return Disease
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
    public function getCausativeOrganisms()
    {
        return $this->causative_organisms;
    }

    /**
     * @param mixed $causative_organisms
     * @return Disease
     */
    public function setCausativeOrganisms($causative_organisms)
    {
        $this->causative_organisms = $causative_organisms;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSignsAndSymptoms()
    {
        return $this->signs_and_symptoms;
    }

    /**
     * @param mixed $signs_and_symptoms
     * @return Disease
     */
    public function setSignsAndSymptoms($signs_and_symptoms)
    {
        $this->signs_and_symptoms = $signs_and_symptoms;
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
     * @return Disease
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}