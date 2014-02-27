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
        
        
        return true;
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
    
    public function connect() {
        
        try{
            $this->_cb_handle = new Couchbase(
                $this->_server.":".$this->_port, 
                $this->_username, 
                $this->_password, 
                $this->_default_bucket
                );
        } catch (couchbase_exception $e) {
            
        }
        
        
    }
    
    public function getConnectionHandle() {
        return $this->_cb_handle;
    }
    
    /**
     * Create connection to couchbase server.
     */
    
    /**
     * save data in server.
     */
    
    /**
     * get the saved data from server.
     */
    
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
     * example $_servers[0] = array( 'server' => '127.0.0.1', 'port' => '8091' );
     * @var array 
     */
    private $_servers = array();
    
    private $_ports;
    
    private $_username;
    
    private $_password;
    
    private $_default_bucket;
    
    
    /**
     * Constructor
     */
    
    
    
}

?>
