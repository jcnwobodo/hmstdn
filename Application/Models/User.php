<?php
namespace Application\Models;

use System\Models\I_StatefulObject;
use System\Utilities\DateTime;

abstract class User extends DomainObject implements I_StatefulObject
{
    private $username;
    private $password;
    private $user_type;
    private $status;
    private $profile_photo;
    private $first_name;
    private $last_name;
    private $other_names;
    private $gender;
    private $date_of_birth;
    private $nationality;
    private $state_of_origin;
    private $lga;
    private $residence_country;
    private $residence_state;
    private $residence_city;
    private $residence_street;
    private $email;
    private $phone;
    private $biography;
    public static $gender_enum = array('m', 'f', 'male', 'female');

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

    public function getProfilePhoto()
    {
        return $this->profile_photo;
    }
    public function setProfilePhoto(Upload $profile_photo)
    {
        $this->profile_photo = $profile_photo;
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

    public function getNames()
    {
        return $this->getFirstName().' '.$this->getOtherNames().' '.$this->getLastName();
    }
    public function getShortName()
    {
        return $this->last_name.", ".substr($this->first_name,0,1).". ".substr($this->other_names,0,1).".";
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function setFirstName($value)
    {
        $this->first_name = $value;
        $this->markDirty();
        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }
    public function setLastName($value)
    {
        $this->last_name = $value;
        $this->markDirty();
        return $this;
    }

    public function getOtherNames()
    {
        return $this->other_names;
    }
    public function setOtherNames($value)
    {
        $this->other_names = $value;
        $this->markDirty();
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }
    public function setGender($value)
    {
        if(in_array(strtolower($value), $this::$gender_enum))
        {
            $this->gender = $value;
            $this->markDirty();
            return $this;
        }
        throw new \Exception("Invalid data: gender");
    }

    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }
    public function setDateOfBirth(DateTime $date)
    {
        $this->date_of_birth = $date;
        $this->markDirty();
        return $this;
    }

    public function getNationality()
    {
        return $this->nationality;
    }
    public function setNationality($value)
    {
        $this->nationality = $value;
        $this->markDirty();
        return $this;
    }

    public function getStateOfOrigin()
    {
        return $this->state_of_origin;
    }
    public function setStateOfOrigin($value)
    {
        $this->state_of_origin = $value;
        $this->markDirty();
        return $this;
    }

    public function getLga()
    {
        return $this->lga;
    }
    public function setLga($value)
    {
        $this->lga = $value;
        $this->markDirty();
        return $this;
    }

    public function getResidenceCountry()
    {
        return $this->residence_country;
    }
    public function setResidenceCountry($residence_country)
    {
        $this->residence_country = $residence_country;
        $this->markDirty();
        return $this;
    }

    public function getResidenceState()
    {
        return $this->residence_state;
    }
    public function setResidenceState($residence_state)
    {
        $this->residence_state = $residence_state;
        $this->markDirty();
        return $this;
    }

    public function getResidenceCity()
    {
        return $this->residence_city;
    }
    public function setResidenceCity($residence_city)
    {
        $this->residence_city = $residence_city;
        $this->markDirty();
        return $this;
    }

    public function getResidenceStreet()
    {
        return $this->residence_street;
    }
    public function setResidenceStreet($residence_street)
    {
        $this->residence_street = $residence_street;
        $this->markDirty();
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        $this->markDirty();
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
        $this->markDirty();
        return $this;
    }

    public function getBiography()
    {
        return $this->biography;
    }
    public function setBiography($biography)
    {
        $this->biography = $biography;
        $this->markDirty();
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
                $command = 'moderator-area';
            } break;

            case (User::UT_RECEPTIONIST) :{
                $command = 'member-area';
            } break;
        }
        return $command;
    }
}