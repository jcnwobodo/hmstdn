<?php
namespace Application\Models;

use System\Utilities\DateTime;

class Session extends DomainObject
{
    private $session_id;
    private $session_user;
    private $user_type;
    private $start_time;
    private $user_agent;
    private $ip_address;
    private $last_activity_time;
    private $status;

    const ON_STATE = 1;
    const OFF_STATE = 0;

    public function __construct($id=null)
    {
        parent::__construct($id);
    }

    public function userAuthorized($user_type_array)
    {
        if(!is_array($user_type_array)){$user_type_array = array($user_type_array);}
        foreach($user_type_array as $user_type)
        {
            if ($this->user_type == $user_type) return true;
        }
        return false;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
        $this->markDirty();
        return $this;
    }

    public function getSessionUser()
    {
        return $this->session_user;
    }
    public function setSessionUser(User $session_user)
    {
        $this->session_user = $session_user;
        $this->markDirty();
        return $this;
    }

    public function getUserType()
    {
        return $this->user_type;
    }
    public function setUserType($user_type)
    {
        $this->user_type = $user_type;
        $this->markDirty();
        return $this;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }
    public function setStartTime(DateTime $start_time)
    {
        $this->start_time = $start_time;
        $this->markDirty();
        return $this;
    }

    public function getUserAgent()
    {
        return $this->user_agent;
    }
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;
        $this->markDirty();
        return $this;
    }

    public function getIpAddress()
    {
        return $this->ip_address;
    }
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
        $this->markDirty();
        return $this;
    }

    public function getLastActivityTime()
    {
        return $this->last_activity_time;
    }
    public function setLastActivityTime(DateTime $last_activity_time)
    {
        $this->last_activity_time = $last_activity_time;
        $this->markDirty();
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
        $this->markDirty();
        return $this;
    }
}