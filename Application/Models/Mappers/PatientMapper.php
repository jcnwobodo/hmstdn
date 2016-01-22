<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    1:19 AM
 **/

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\PatientCollection;

class PatientMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_patients WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_patients");
        $this->selectByCardNumberStmt = self::$PDO->prepare("SELECT * FROM app_patients WHERE card_number=?");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_patients WHERE status=?");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_patients set card_number=?,blood_group=?,genotype=?,personal_info=?,status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_patients (card_number,blood_group,genotype,personal_info,status)VALUES(?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_patients WHERE id=?");
    }

    public function findByCardNumber($card_number)
    {
        return $this->findHelper($card_number, $this->selectByCardNumberStmt, 'card_number');
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Patient";
    }

    protected function getCollection( array $raw )
    {
        return new PatientCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setCardNumber($array['card_number']);
        $object->setBloodGroup($array['blood_group']);
        $object->setGenotype($array['genotype']);
        $personal_info = Models\PersonalInfo::getMapper('PersonalInfo')->find($array['personal_info']);
        if(! is_null($personal_info)) $object->setPersonalInfo($personal_info);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getCardNumber(),
            $object->getBloodGroup(),
            $object->getGenotype(),
            ($object instanceof Models\PersonalInfo) ? $object->getPersonalInfo()->getId() : NULL,
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getCardNumber(),
            $object->getBloodGroup(),
            $object->getGenotype(),
            $object->getPersonalInfo()->getId(),
            $object->getStatus(),
            $object->getId()
        );
        $this->updateStmt->execute( $values );
    }

    protected function doDelete(Models\DomainObject $object )
    {
        $values = array( $object->getId() );
        $object->getPersonalInfo()->markDelete();
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