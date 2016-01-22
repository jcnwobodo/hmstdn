<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:15 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\PersonalInfoCollection;
use System\Utilities\DateTime;

class PersonalInfoMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_personal_info WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_personal_info");
        $this->selectByGenderStmt = self::$PDO->prepare("SELECT * FROM site_personal_info WHERE gender=?");
        $this->selectByEmailStmt = self::$PDO->prepare("SELECT * FROM site_personal_info WHERE email=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_personal_info set photo=?,first_name=?, last_name=?, other_names=?, gender=?, date_of_birth=?, nationality=?, state_of_origin=?, lga=?, residence_country=?, residence_state=?, residence_city=?, residence_street=?, email=?, phone=?, biography=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_personal_info (id,photo,first_name,last_name,other_names,gender,date_of_birth,nationality,state_of_origin,lga,residence_country,residence_state,residence_city,residence_street,email,phone,biography)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_personal_info WHERE id=?");
    }

    public function findByGender($gender)
    {
        $this->selectByGenderStmt->execute( array($gender) );
        $raw_data = $this->selectByGenderStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByEmail($email)
    {
        return $this->findHelper($email, $this->selectByEmailStmt, 'email');
    }

    protected function targetClass()
    {
        return "Application\\Models\\PersonalInfo";
    }

    protected function getCollection( array $raw )
    {
        return new PersonalInfoCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $profile_photo = Models\Upload::getMapper('Upload')->find($array['photo']);
        if(! is_null($profile_photo)) $object->setProfilePhoto($profile_photo);
        $object->setFirstName($array['first_name']);
        $object->setLastName($array['last_name']);
        $object->setOtherNames($array['other_names']);
        $object->setGender($array['gender']);
        $object->setDateOfBirth(DateTime::getDateTimeObjFromInt($array['date_of_birth']));
        $object->setNationality($array['nationality']);
        $object->setStateOfOrigin($array['state_of_origin']);
        $object->setLga($array['lga']);
        $object->setResidenceCountry($array['residence_country']);
        $object->setResidenceState($array['residence_state']);
        $object->setResidenceCity($array['residence_city']);
        $object->setResidenceStreet($array['residence_street']);
        $object->setEmail($array['email']);
        $object->setPhone($array['phone']);
        $object->setBiography($array['biography']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getId(),
            is_object($object->getProfilePhoto()) ? $object->getProfilePhoto()->getId() : NULL,
            $object->getFirstName(),
            $object->getLastName(),
            $object->getOtherNames(),
            $object->getGender(),
            $object->getDateOfBirth()->getDateTimeInt(),
            $object->getNationality(),
            $object->getStateOfOrigin(),
            $object->getLga(),
            $object->getResidenceCountry(),
            $object->getResidenceState(),
            $object->getResidenceCity(),
            $object->getResidenceStreet(),
            $object->getEmail(),
            $object->getPhone(),
            $object->getBiography()
        );
        $this->insertStmt->execute( $values );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            is_object($object->getProfilePhoto()) ? $object->getProfilePhoto()->getId() : NULL,
            $object->getFirstName(),
            $object->getLastName(),
            $object->getOtherNames(),
            $object->getGender(),
            $object->getDateOfBirth()->getDateTimeInt(),
            $object->getNationality(),
            $object->getStateOfOrigin(),
            $object->getLga(),
            $object->getResidenceCountry(),
            $object->getResidenceState(),
            $object->getResidenceCity(),
            $object->getResidenceStreet(),
            $object->getEmail(),
            $object->getPhone(),
            $object->getBiography(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    protected function doDelete(Models\DomainObject $object )
    {
        $values = array( $object->getId() );
        $this->deleteStmt->execute( $values );
    }

    protected function selectStmt()
    {
        return $this->selectStmt;
    }

    protected function selectAllStmt()
    {
        return $this->selectAllStmt;
    }
}