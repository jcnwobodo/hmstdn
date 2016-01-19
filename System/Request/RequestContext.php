<?php
namespace System\Request;

use System\Models\DomainObjectWatcher;
use System\Exceptions;
use Application\Models\Session;
use System\Auth\AccessManager;

class RequestContext
{
    private static $instance;

    private $session;
    private $request_url;
    private $request_url_params;
    private $request_command = array();
    private $request_data = array();
    private $request_cookies = array();
    private $request_files = array();
    private $flash_data = null;
    private $response_data = null;
    private static $views_directory;
    private $view;


    public static function instance()
    {
        if( ! isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        filter_input_array(INPUT_POST);
        filter_input_array(INPUT_GET);
        $array = array_merge($_POST, $_GET );
        /**
         * TODO
         * fix input-mode bug caused due to the treatment of POST and GET data as coming from same source
         */
        $this->sanitizeInput($array);
        $this->setRequestUrl(site_info('deployment-path',false), ""); //no slashes at the end of address
        $this->request_url_params = $this->setRequestUrlParamsArray();
        $this->setRequestDataArray($array);
        $this->addCommand( isset($this->request_url_params[0]) ? $this->request_url_params[0] : "Default" );
        $this->request_cookies = filter_input_array(INPUT_COOKIE);
        $this->request_files = $_FILES;
        self::$views_directory = site_info('views-directory',false);
    }

    private function sanitizeInput(&$array)
    {
        if ($array !== FALSE && $array !== null)
        {
            foreach ($array as $key => $value)
            {
                if (is_array($array[$key]))
                {
                    $this->sanitizeInput($array[$key]);
                }
                else
                {
                    $array[$key] = html_entity_decode($array[$key]);
                }
            }
        }
    }
    private function setRequestDataArray($array)
    {
        if(!empty($array) and $array !== FALSE && $array !== null)
        {
            $this->request_data = $array;
        }
    }
    private function setRequestUrlParamsArray()
    {
        $raw = explode("/", $this->request_url);
        $processed = array();
        foreach($raw as $param)
        {
            if(strlen($param)) $processed[] = $param;
        }
        return $processed;
    }

    public function redirect($url, $replace=true)
    {
        DomainObjectWatcher::instance()->performOperations();
        header("Location:{$url}", $replace);
    }

    public function getSession()
    {
        if(!isset($this->session))
        {
            AccessManager::instance()->validateSession($this);
        }
        return $this->session;
    }
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    public function getRequestUrl()
    {
        return implode('/' , $this->request_url_params);
    }
    public function setRequestUrl($replace_path='', $replacement='')
    {
        $complete_url = $_SERVER['REQUEST_URI'];
        $complete_url_arr = explode('?', $complete_url);
        $fore_q_mark = $complete_url_arr[0];
        $this->request_url = substr( str_replace(strtolower($replace_path), $replacement, strtolower($fore_q_mark)) , 1);
    }
    public function getRequestUrlParam($index)
    {
        if(isset($this->request_url_params[(int)$index]))
        {
            return $this->request_url_params[$index];
        }
        return null;
    }
    public function isRequestUrl($url)
    {
        return ( strtolower($url) == strtolower($this->getRequestUrl()) or strtolower($url)==strtolower($this->getRequestUrlParam(0)));
    }

    public function addCommand($command)
    {
        $this->request_command[] = $command;
        return $this;
    }
    public function getCommandChain()
    {
        return $this->request_command;
    }
    public function resetCommandChain()
    {
        $this->request_command = array();
        return $this;
    }

    public function fieldIsSet($field_name)
    {
        if(isset($this->request_data[$field_name]))
        {
            return true;
        }
        return false;
    }
    public function getField($field_name)
    {
        if(isset($this->request_data[$field_name]))
        {
            return $this->request_data[$field_name];
        }
        throw new Exceptions\FormFieldNotFoundException("field '{$field_name}' not found in current request context");
    }
    public function getAllFields()
    {
        return $this->request_data;
    }

    public function getCookie($name)
    {
        if(isset( $this->request_cookies[$name] ))
        {
            return $this->request_cookies[$name];
        }
        return null;
    }
    public function getAllCookies()
    {
        return $this->request_cookies;
    }

    public function getFile($name)
    {
        if(isset( $this->request_files[$name] ))
        {
            return $this->request_files[$name];
        }
        return null;
    }
    public function getAllFiles()
    {
        return $this->request_files;
    }

    public function getResponseData()
    {
        return $this->response_data;
    }
    public function setResponseData($data)
    {
        $this->response_data = $data;
    }

    public function getFlashData()
    {
        return $this->flash_data;
    }
    public function setFlashData($flash_data)
    {
        $this->flash_data = $flash_data;
        return $this;
    }

    public function getView()
    {
        if(isset($this->view))
        {
            return $this->view;
        }
        return null;
    }
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    public function invokeView()
    {
        if($this->viewExists($this->getView()))
        {
            require_once($this::$views_directory.$this->getView());
        }
        else
        {
            echo "<h1>File Not Found.</h1><h4>{$this::$views_directory}{$this->getView()}</h4>";
        }
    }
    public function viewExists($view)
    {
        return (is_file($this::$views_directory.$view)) ? true : false;
    }
}