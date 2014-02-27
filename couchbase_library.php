<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Couchbase exception class
 */

class couchbase_exception extends Exception {}

/**
 * 
 */
class couchbase_server {
    
    private $_server;
    
    private $_port;
    
    private $_username;
    
    private $_password;
    
    private $_default_bucket;
    
    private $_cb_handle;
    
    
    public function __construct($customData = array()) {
        
        $this->_setDefault();
        
        $this->init($customData);
        
        $this->connect();
        
    }


    private function _setDefault() {
        
        $this->_server = "127.0.0.1";
        $this->_port = "8091";
        $this->_username = "";
        $this->_password = "";
        $this->_default_bucket = "default";
        
    }


    public function init($customData = array()) {
        
        if(!empty($customData)) {
            
            if(isset($customData['server'])) {
                $this->_server = $customData['server'];
            }
            
            if(isset($customData['port'])) {
                $this->_port = $customData['port'];
            }
            
            if(isset($customData['username'])) {
                $this->_username = $customData['username'];
            }
            
            if(isset($customData['password'])) {
                $this->_password = $customData['password'];
            }
            
            if(isset($customData['default_bucket'])) {
                $this->_default_bucket = $customData['default_bucket'];
            }
            
        } else {
            return false;
        }
    }
    
    /**
     * Create connection to couchbase server.
     */
    public function connect() {
        
        try{
            $this->_cb_handle = new Couchbase(
                $this->_server.":".$this->_port, 
                $this->_username, 
                $this->_password, 
                $this->_default_bucket
                );
        } catch (couchbase_exception $exc) {
            echo $exc->getTraceAsString();
        }
        
        
    }
    
    public function getConnectionHandle() {
        return $this->_cb_handle;
    }
    
    
    /**
     * save data in server.
     */
    public function saveData($key, $data) {
        
        try {
            $this->_cb_handle->set($key, $data);
            
        } catch (couchbase_exception $exc) {
            echo $exc->getTraceAsString();
        } 
        
    }


    /**
     * get the saved data from server.
     */
    public function getData($key) {
        
        try {
            
            return $this->_cb_handle->get($key);
            
        } catch (couchbase_exception $exc) {
            echo $exc->getTraceAsString();
        } 
        
    }
    
    /**
     * delete data from server.
     */
    
    /**
     * create bucket
     */
    
    /**
     * edit bucket.
     */
    
    /**
     * delete bucket.
     */
    
    
}


/**
 * Description of couchbase_library
 *
 * @author vsingh
 */
class couchbase_library {
    
    /**
     * Array of server address and ports.
     * example $_servers[0] = array( 'server' => '127.0.0.1', 
     * 'port' => '8091', 'username' => '', 'password' => '', 'bucket' => 'default');
     * @var array 
     */
    private $_servers = array();
    
    /**
     *
     * @var object 
     */
    private $_serverObj;
    
    /**
     * 
     */
    private $key_salt = 'my secret key salt';
            
    
    /**
     * Constructor
     */
    
    public function __construct() {
        
        $this->_serverObj = new couchbase_server();
    }
    
    /**
     * 
     * @param array $server
     */
    public function addservers($serverName, Array $serverDetails) {
        
         $this->_servers[$serverName] = array(
             
             'server' => $server['server'], 
             'port' => $server['port'], 
             'username' => $server['username'], 
             'password' => $server['password'], 
             'default_bucket' =>  $server['bucket']
             
             );
         
         
    }
    
    public function connectAll() {
        
        foreach ($this->_servers as $server_name => $server_detail) {
            
            $this->_serverObj[$server_name] = new couchbase_server($server_detail);
        }
    }
    
    
    public function addData($key, $data) {
        $key = md5($key.$this->key_salt);
        
        if(!$this->isJson($data)) {
            $data = json_encode($data);
        }
        
        $this->getServer()->saveData($key, $data);
        
        return true;
    }
    
    public function getData($key) {
        
        return $this->getServer()->saveData($key);
        
    }
    
    public function getServer() {
        /**
         * temporary 
         */
        return reset($this->_serverObj);
    }
    
    /**
     * 
     * @param String $string
     * @return boolean
     */
    public function isJson($string) {
        
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
        
   }
    
}

?>
