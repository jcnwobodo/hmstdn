<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackMarket
 * Date:    11/23/2015
 * Time:    3:11 AM
 **/

namespace Application\Models\Mappers;

use Application\Models;
use Application\Models\Collections\LocationCollection;

class LocationMapper extends Mapper
{
    public function __construct()
    {
        parent::__construct();
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM site_locations WHERE id=?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM site_locations ORDER BY location_type, parent, location_name");
        $this->selectByTypeStmt = self::$PDO->prepare("SELECT * FROM site_locations WHERE location_type=? ORDER BY parent, location_name");
        $this->selectByStatusStmt = self::$PDO->prepare("SELECT * FROM site_locations WHERE status=?");
        $this->selectTypeByStatusStmt = self::$PDO->prepare("SELECT * FROM site_locations WHERE location_type=? AND status=? ORDER BY parent, location_name");
        $this->updateStmt = self::$PDO->prepare("UPDATE site_locations set parent=?, location_name=?, slogan=?, location_type=?, latitude=?, longitude=?, status=? WHERE id=?");
        $this->insertStmt = self::$PDO->prepare("INSERT INTO site_locations (parent, location_name, slogan, location_type, latitude, longitude, status) VALUES (?,?,?,?,?,?,?)");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM site_locations WHERE id=?");
    }

    public function findByType($type)
    {
        $this->selectByTypeStmt->execute( array($type) );
        $raw_data = $this->selectByTypeStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findByStatus($status)
    {
        $this->selectByStatusStmt->execute( array($status) );
        $raw_data = $this->selectByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    public function findTypeByStatus($type, $status)
    {
        $this->selectTypeByStatusStmt->execute( array($type, $status) );
        $raw_data = $this->selectTypeByStatusStmt->fetchAll(\PDO::FETCH_ASSOC);
        return $this->getCollection( $raw_data );
    }

    protected function targetClass()
    {
        return "Application\\Models\\Location";
    }

    protected function getCollection( array $raw )
    {
        return new LocationCollection( $raw, $this );
    }

    protected function doCreateObject( array $array )
    {
        $class = $this->targetClass();
        $object = new $class($array['id']);
        $parent = $this->find($array['parent']);
        if(! is_null($parent)) $object->setParent($parent);
        $object->setLocationName($array['location_name']);
        $object->setSlogan($array['slogan']);
        $object->setLocationType($array['location_type']);
        $object->setLatitude($array['latitude']);
        $object->setLongitude($array['longitude']);
        $object->setStatus($array['status']);

        return $object;
    }

    protected function doInsert(Models\DomainObject $object )
    {
        $parent_id = is_object($object->getParent()) ? $object->getParent()->getId() : NULL;
        $values = array(
            $parent_id,
            $object->getLocationName(),
            $object->getSlogan(),
            $object->getLocationType(),
            $object->getLatitude(),
            $object->getLongitude(),
            $object->getStatus()
        );
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );
    }

    protected function doUpdate(Models\DomainObject $object )
    {
        $parent_id = is_object($object->getParent()) ? $object->getParent()->getId() : NULL;
        $values = array(
            $parent_id,
            $object->getLocationName(),
            $object->getSlogan(),
            $object->getLocationType(),
            $object->getLatitude(),
            $object->getLongitude(),
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