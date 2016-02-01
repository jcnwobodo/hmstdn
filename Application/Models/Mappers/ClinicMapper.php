<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: HMSTDN
 * Date:    2/1/2016
 * Time:    11:32 AM
 **/

namespace Application\Models\Mappers;


use Application\Models;
use Application\Models\Collections\ClinicCollection;

class ClinicMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_clinics WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_clinics ORDER BY name");
        $this->selectByClinicIdStmt = self::$PDO->prepare("SELECT * FROM app_clinics WHERE clinic_id=?");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_clinics WHERE status=? ORDER BY name");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_clinics SET clinic_id=?, name=?, location_state=?, location_street=?, contact_email=?, contact_phone=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_clinics (clinic_id,name,location_state,location_street,contact_email,contact_phone,status)VALUES(?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_clinics WHERE id=?");
    }

    public function findByClinicId($clinic_id)
    {
        return $this->findHelper($clinic_id, $this->selectByClinicIdStmt, 'clinic_id');
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Clinic";
    }

    protected function getCollection( array $raw )
    {
        return new ClinicCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setClinicId($array['clinic_id']);
        $object->setName($array['name']);

        //clinic location
        $location_state = Models\Location::getMapper("Location")->find($array['location_state']);
        if( is_object($location_state)) $object->setLocationState($location_state);

        $object->setLocationStreet($array['location_street']);
        $object->setContactEmail($array['contact_email']);
        $object->setContactPhone($array['contact_phone']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getClinicId(),
            $object->getName(),
            $object->getLocationState(),
            $object->getLocationStreet(),
            $object->getContactEmail(),
            $object->getContactPhone(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getClinicId(),
            $object->getName(),
            $object->getLocationState(),
            $object->getLocationStreet(),
            $object->getContactEmail(),
            $object->getContactPhone(),
            $object->getStatus(),
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