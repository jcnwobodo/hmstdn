<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    3:50 PM
 */

namespace Application\Models;

use System\Models\I_StatefulObject;

abstract class User extends DomainObject implements I_StatefulObject
{
    private $username;
    private $password;
    private $user_type;
    private $status;

    private $personal_info;

    const UT_ADMIN = 'Admin';
    const UT_LAB_TECH = 'LabTechnician';
    const UT_RECEPTIONIST = 'Receptionist';
    const UT_DOCTOR = 'Doctor';
    const UT_RESEARCHER = 'Researcher';

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
        $this->markDirty();
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * @param mixed $user_type
     * @return User
     */
    public function setUserType($user_type)
    {
        $this->user_type = ucfirst($user_type);
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
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @param PersonalInfo $personal_info
     * @return User
     */
    public function setPersonalInfo(PersonalInfo $personal_info)
    {
        $this->personal_info = $personal_info;
        return $this;
    }

    public static function getDefaultCommand($user_type)
    {
        $command = null;
        switch(ucfirst($user_type))
        {
            case (User::UT_ADMIN) :{
                $command = 'admin-area';
            } break;

            case (User::UT_LAB_TECH) :{
                $command = 'lab-tech-area';
            } break;

            case (User::UT_RECEPTIONIST) :{
                $command = 'reception';
            } break;

            case (User::UT_DOCTOR) :{
                $command = 'doctor-area';
            } break;

            case (User::UT_RESEARCHER) :{
                $command = 'research-center';
            }
        }
        return $command;
    }

    public function defaultCommand()
    {
        return self::getDefaultCommand($this->getUserType());
    }
}