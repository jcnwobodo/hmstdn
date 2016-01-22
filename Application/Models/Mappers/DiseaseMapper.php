<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/22/2016
 * Time:    6:05 PM
 **/

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\DiseaseCollection;

class DiseaseMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_diseases WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_diseases");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_diseases SET name=?, causative_organisms=?, signs_and_symptoms=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_diseases (name,causative_organisms,signs_and_symptoms) VALUES (?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_diseases WHERE id=?");
    }

    protected function targetClass()
    {
        return "Application\\Models\\Disease";
    }

    protected function getCollection( array $raw )
    {
        return new DiseaseCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $object->setName($array['name']);
        $object->setCausativeOrganisms($array['causative_organisms']);
        $object->setSignsAndSymptoms($array['signs_and_symptoms']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getName(),
            $object->getCausativeOrganisms(),
            $object->getSignsAndSymptoms()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $values = array(
            $object->getName(),
            $object->getCausativeOrganisms(),
            $object->getSignsAndSymptoms(),
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