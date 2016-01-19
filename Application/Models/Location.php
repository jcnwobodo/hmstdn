<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (jc.nwobodo@gmail.com)
 * Project: PoliceBlackmarket
 * Date:    11/16/2015
 * Time:    10:26 PM
 */

namespace Application\Models;


use System\Models\I_StatefulObject;

class Location extends DomainObject implements I_StatefulObject
{
    private $parent;
    private $location_name;
    private $slogan;
    private $location_type; //state || lga || town
    private $latitude;
    private $longitude;
    private $status;

    const TYPE_STATE = 'state';
    const TYPE_LGA = 'lga';
    const TYPE_DISTRICT = 'district';

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return Location
     */
    public function setParent(self $parent)
    {
        $this->parent = $parent;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * @param mixed $location_name
     * @return Location
     */
    public function setLocationName($location_name)
    {
        $this->location_name = $location_name;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocationType()
    {
        return $this->location_type;
    }

    /**
     * @param mixed $location_type
     * @return Location
     */
    public function setLocationType($location_type)
    {
        $this->location_type = $location_type;
        $this->markDirty();
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * @param mixed $slogan
     * @return Location
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
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
     * @return Location
     */
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}