<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: RBHCISTD
 * Date:    1/23/2016
 * Time:    11:22 AM
 **/

namespace Application\Models\Mappers;


use Application\Models;
use System\Utilities\DateTime;
use Application\Models\Collections\LabTestCollection;

class LabTestMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests");
        $this->updateStmt = self::$PDO->prepare("UPDATE app_lab_tests SET consultation=?, operator=?, disease=?, request_date=?, test_date=?, patient_location=?, result=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO app_lab_tests (consultation,operator,disease,request_date,test_date,patient_location,result,status) VALUES (?,?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM app_lab_tests WHERE id=?");

        $this->selectByConsultationStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE consultation=?");
        $this->selectByOperatorStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE operator=?");
        $this->selectByDiseaseStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE disease=?");
        $this->selectByDateRangeStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE test_date>=? AND test_date<=?");
        $this->selectByPatientLocationStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE patient_location=?");
        $this->selectByDateRangeAndDiseaseStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE test_date>=:start AND test_date<=:end_d AND disease=:disease_id");
        $this->selectByDateRangeAndLocationStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE test_date>=:start AND test_date<=:end_d AND patient_location=:location_id");
        $this->selectByResultStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE result=? AND status=1");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM app_lab_tests WHERE status=?");
        $this->deleteByConsultationStmt = self::$PDO->prepare("DELETE FROM app_lab_tests WHERE consultation=?");
    }

    public function findByConsultation($consultation_id)
    {
        $this->selectByConsultationStmt->execute( array($consultation_id) );
        $raw_data = $this->selectByConsultationStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByOperator($operator_id)
    {
        $this->selectByOperatorStmt->execute( array($operator_id) );
        $raw_data = $this->selectByOperatorStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByDisease($disease_id)
    {
        $this->selectByDiseaseStmt->execute( array($disease_id) );
        $raw_data = $this->selectByDiseaseStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByDateRange($lower_limit, $upper_limit)
    {
        $this->selectByDateRangeStmt->execute( array($lower_limit, $upper_limit) );
        $raw_data = $this->selectByDateRangeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByPatientLocation($location_id)
    {
        $this->selectByPatientLocationStmt->execute( array($location_id) );
        $raw_data = $this->selectByPatientLocationStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByDateRangeAndDisease($lower_limit, $upper_limit, $disease)
    {
        $this->selectByDateRangeAndDiseaseStmt->bindParam(':start', $lower_limit, \PDO::PARAM_INT);
        $this->selectByDateRangeAndDiseaseStmt->bindParam(':end_d', $upper_limit, \PDO::PARAM_INT);
        $this->selectByDateRangeAndDiseaseStmt->bindParam(':disease_id', $disease, \PDO::PARAM_INT);
        $this->selectByDateRangeAndDiseaseStmt->execute();
        $raw_data = $this->selectByDateRangeAndDiseaseStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByDateRangeAndLocation($lower_limit, $upper_limit, $location)
    {
        $this->selectByDateRangeAndLocationStmt->bindParam(':start', $lower_limit, \PDO::PARAM_INT);
        $this->selectByDateRangeAndLocationStmt->bindParam(':end_d', $upper_limit, \PDO::PARAM_INT);
        $this->selectByDateRangeAndLocationStmt->bindParam(':location_id', $location, \PDO::PARAM_INT);
        $this->selectByDateRangeAndLocationStmt->execute();
        $raw_data = $this->selectByDateRangeAndLocationStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByResult($result=1)
    {
        $this->selectByResultStmt->execute( array($result) );
        $raw_data = $this->selectByResultStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function deleteByConsultation($consultation_id)
    {
        $values = array( $consultation_id );
        $this->deleteByConsultationStmt->execute( $values );
    }

    protected function targetClass()
    {
        return "Application\\Models\\LabTest";
    }

    protected function getCollection( array $raw )
    {
        return new LabTestCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);

        $consultation = Models\Consultation::getMapper('Consultation')->find($array['consultation']);
        if(is_object($consultation)) $object->setConsultation($consultation);

        $operator = Models\LabTechnician::getMapper('LabTechnician')->find($array['operator']);
        if(is_object($operator)) $object->setOperator($operator);

        $disease = Models\Disease::getMapper('Disease')->find($array['disease']);
        if(is_object($disease)) $object->setDisease($disease);

        $object->setRequestDate(new DateTime($array['request_date']));
        $object->setTestDate(new DateTime($array['test_date']));

        $patient_location = Models\Location::getMapper('Location')->find($array['patient_location']);
        if(is_object($patient_location)) $object->setPatientLocation($patient_location);

        $object->setResult($array['result']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $consultation_id = is_object($object->getConsultation()) ? $object->getConsultation()->getId() : NULL;
        $operator_id = is_object($object->getOperator()) ? $object->getOperator()->getId() : NULL;
        $disease_id = is_object($object->getDisease()) ? $object->getDisease()->getId() : NULL;
        $location_id = is_object($object->getPatientLocation()) ? $object->getPatientLocation()->getId() : NULL;

        $values = array(
            $consultation_id,
            $operator_id,
            $disease_id,
            $object->getRequestDate()->getDateTimeInt(),
            is_object($object->getTestDate()) ? $object->getTestDate()->getDateTimeInt() : NULL,
            $location_id,
            $object->getResult(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $consultation_id = is_object($object->getConsultation()) ? $object->getConsultation()->getId() : NULL;
        $operator_id = is_object($object->getOperator()) ? $object->getOperator()->getId() : NULL;
        $disease_id = is_object($object->getDisease()) ? $object->getDisease()->getId() : NULL;
        $location_id = is_object($object->getPatientLocation()) ? $object->getPatientLocation()->getId() : NULL;

        $values = array(
            $consultation_id,
            $operator_id,
            $disease_id,
            $object->getRequestDate()->getDateTimeInt(),
            $object->getTestDate()->getDateTimeInt(),
            $location_id,
            $object->getResult(),
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