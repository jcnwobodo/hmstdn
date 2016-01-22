<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/21/2016
 * Time:    10:05 PM
 **/

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\EmploymentDataCollection;

class EmploymentDataMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_employment_data WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_employment_data");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_employment_data SET department=?, specialization=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_employment_data (id, department, specialization)VALUES(?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_employment_data WHERE id=?");
    }

    protected function targetClass()
    {
        return "Application\\Models\\EmploymentData";
    }

    protected function getCollection( array $raw )
    {
        return new EmploymentDataCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setDepartment($array['department']);
        $object->setSpecialization($array['specialization']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getId(),
            $object->getDepartment(),
            $object->getSpecialization()
        );
        $this->insertStmt->execute( $values );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getDepartment(),
            $object->getSpecialization(),
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