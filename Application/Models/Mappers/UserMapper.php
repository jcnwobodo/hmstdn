<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/26/2015
 * Time:    4:28 PM
 */

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\UserCollection;
use System\Utilities\DateTime;

class UserMapper extends Mapper
{
    private $target_class;

    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_users");
        $this->selectByUsernameStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE username=?");
        $this->selectByGenderStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE gender=?");
        $this->selectByEmailStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE email=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_users set username=?,password=?,user_type=?,status=?,photo=?,first_name=?, last_name=?, other_names=?, gender=?, date_of_birth=?, nationality=?, state_of_origin=?, lga=?, residence_country=?, residence_state=?, residence_city=?, residence_street=?, email=?, phone=?, biography=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_users (username,password,user_type,status,photo,first_name,last_name,other_names,gender,date_of_birth,nationality,state_of_origin,lga,residence_country,residence_state,residence_city,residence_street,email,phone,biography)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_users WHERE id=?");

        $this->selectAllByUserTypeStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE user_type=?;");
        $this->selectRandomByUserTypeStmt = self::$PDO->prepare("SELECT * FROM site_users WHERE user_type=:user_type AND status=:user_status ORDER BY RAND() LIMIT :num");
    }

    public function findByUsername($username)
    {
        return $this->findHelper($username, $this->selectByUsernameStmt, 'username');
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

    public function findByUserType($user_type)
    {
        $this->selectAllByUserTypeStmt->execute( array($user_type) );
        $raw_data = $this->selectAllByUserTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findRandomByUserType($user_type, $limit=1, $status=1)
    {
        $this->selectRandomByUserTypeStmt->bindParam(':user_type', $user_type, \PDO::PARAM_STR);
        $this->selectRandomByUserTypeStmt->bindParam(':num', $limit, \PDO::PARAM_INT);
        $this->selectRandomByUserTypeStmt->bindParam(':user_status', $status, \PDO::PARAM_INT);
        $this->selectRandomByUserTypeStmt->execute();
        $raw_data = $this->selectRandomByUserTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\{$this->target_class}";
    }

    protected function getCollection( array $raw )
    {
        return new UserCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $this->target_class = ucfirst($array['user_type']);
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setUsername($array['username']);
        $object->setPassword($array['password']);
        $object->setUserType($array['user_type']);
        $object->setStatus($array['status']);
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
            $object->getUsername(),
            $object->getPassword(),
            $object->getUserType(),
            $object->getStatus(),
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
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getUsername(),
            $object->getPassword(),
            $object->getUserType(),
            $object->getStatus(),
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