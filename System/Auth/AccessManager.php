<?php
namespace System\Auth;

use Application\Models\User;
use Application\Models\Session;
use System\Request\RequestContext;
use System\Utilities\DateTime;

//handles all aspects of authentication and authorization
class AccessManager
{
    private static $instance;
    private $message = null;
    private static $SESSION_COOKIE_DOMAIN;
    private static $SESSION_COOKIE_NAME;

    private function __construct()
    {
        self::$SESSION_COOKIE_DOMAIN = site_info('session-cookie-domain', 0);
        self::$SESSION_COOKIE_NAME = site_info('session-cookie-name', 0);
    }
    public static function instance()
    {
        if( ! isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function login($username, $password)
    {
        if(!strlen($username) or !strlen($password))
        {
            $this->setMessage("Please supply a username and password");
            return false;
        }

        $UserMapper = User::getMapper("User");
        $UserObj = $UserMapper->findByUsername($username);

        if(is_null($UserObj))
        {
            $this->setMessage("User $username does not exist.");
            return false;
        }
        elseif($UserObj->getPassword() !== $password)
        {
            $this->setMessage("Invalid password for user $username");
            return false;
        }
        elseif(is_object($UserObj))
        {
            if($UserObj->getStatus() == User::STATUS_INACTIVE)
            {
                $this->setMessage("This account has not been activated, you need to activate your account before you can login.");
                return false;
            }
            $this->startSession($UserObj);
            $this->setMessage("Login successful");
            return true;
        }
        else//an internal error has probably occurred
        {
            $this->setMessage("Login attempt failed. Please try again later. If problem persists, contact the site administrator.");
        }
        return false;
    }
    public function validateSession(RequestContext $requestContext)
    {
        $session_id = $requestContext->getCookie(self::$SESSION_COOKIE_NAME);
        if(! is_null($session_id))
        {
            $session = Session::getMapper('Session')->findBySessionId($session_id);
            if(is_object($session) and $session->getStatus() == $session::ON_STATE)
            {
                $session->setLastActivityTime(new DateTime());
                $requestContext->setSession($session);
                return true;
            }
        }
        return false;
    }
    public function logout($session_id)
    {
        $session = Session::getMapper('Session')->findBySessionId($session_id);
        if(! is_null($session))
        {
            $session->setStatus($session::OFF_STATE);
        }
    }

    private function startSession(User $UserObj)
    {
        $session_id = $this->getUniqueId();
        $user_type = $UserObj->getUserType();

        if(!is_null($user_type) and setcookie( self::$SESSION_COOKIE_NAME, $session_id, null, '/', self::$SESSION_COOKIE_DOMAIN) )
        {
            $session = new Session();
            $session->setSessionId($session_id);
            $session->setSessionUser($UserObj)->setUserType($user_type);
            $session->setStartTime(new DateTime())->setLastActivityTime(new DateTime());
            $session->setUserAgent($_SERVER['HTTP_USER_AGENT'])->setIpAddress($_SERVER['REMOTE_ADDR']);
            $session->setStatus($session::ON_STATE);

            //TODO log this event

            RequestContext::instance()->setSession($session);
            $this->setMessage("Session started successfully");
            return true;
        }
        elseif(is_null($user_type))
        {
            $this->setMessage("An internal error has occurred, try again later.");
            //TODO log this error
        }
        else//cookie could not be set
        {
            $this->setMessage("Cookies could not be set. Please check your browser settings.");
        }
        return false;
    }

    public function getUniqueId($prefix="")
    {
        return uniqid($prefix, true);
    }

    public function getMessage()
    {
        return $this->message;
    }
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}