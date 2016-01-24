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
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_diseases ORDER BY name");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_diseases WHERE status=? ORDER BY name");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_diseases SET name=?, causative_organisms=?, signs_and_symptoms=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_diseases (name,causative_organisms,signs_and_symptoms,status) VALUES (?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_diseases WHERE id=?");
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
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
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $values = array(
            $object->getName(),
            $object->getCausativeOrganisms(),
            $object->getSignsAndSymptoms(),
            $object->getStatus()
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