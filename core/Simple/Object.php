<?php
    /*
    *   Simple Objects version 1.0
    *
    *   Imagina - Plugin.
    *
    *
    *   Copyright (c) 2012 Dolem Labs
    *
    *   Authors:    Paul Marclay (paul.eduardo.marclay@gmail.com)
    *
    */

	class Simple_Object extends Ancestor {
        private $_data = array();
        
        // -- Constructor & Destructor
        
        public function __construct($data = array()) {
            $this->_data = $data;
		}
        
        public function __destruct() {
            foreach ($this as $index => $value){
	             unset($this->$index);
	        }
        }
        
        // -- Auto for get/set/has fields values
        
        public function __call($method, $args) {
	    	switch (substr($method, 0, 3)) {
            case 'get' :
                $key = Conversor::underscore(substr($method,3));
                $data = $this->getData($key, isset($args[0]) ? $args[0] : null);
                return $data;

            case 'set' :
                $key = Conversor::underscore(substr($method,3));
                $result = $this->setData($key, isset($args[0]) ? $args[0] : null);
                return $result;
	    	
            case 'has' :
                $key = Conversor::underscore(substr($method,3));
                return $this->hasData($key);
                
            case 'uns' :
                $key = Conversor::underscore(substr($method,3));
                $result = $this->unsetData($key);
                return $result;
	    	}
            
	    }
        
        public function getData($key = '') {
	    	if ($this->hasData($key)) {
                return $this->_data[$key];
            }
	    }
	    
	    protected function setData($key, $value=null) {
            $this->_data[$key] = $value;
	        return $this;
	    }
        
        public function setDataArray($data = array(), $excludeFields = array()) {
            foreach ($data as $key => $value) {
                if (in_array($key, $excludeFields) || !$this->hasData($key)) continue;
                $this->setData($key, $value);
            }
            
            return $this;
        }
        
        protected function hasData($key) {
            return in_array($key, array_keys($this->_data));
        }
        
        protected function unsetData($key=null) {
	        if (is_null($key)) {
	            $this->_data = array();
	        } else {
	            unset($this->_data[$key]);
	        }
	        return $this;
	    }
        
        // -- Misc methods
        
        public function isEmpty() {
	        return (empty($this->_data)) ? true : false;
	    }
        
        public function clear() {
	    	foreach ($this->getData() as $key => $value)
            $this->_data[$key] = null;
	    }
        
        // -- Conversions

        public function toArray() {
            return $this->_data;
        }

        public function toString() {
            return serialize($this);
        }

        public function toXml($includeHeaders = false) {
            return Array2XML::createXML(null, $this->toArray());
        }

        public function toCsv($enclosed = '"', $fieldSeparator = ',', $lineSeparator = '\n', $includeHeaders = false) {
            $keys   = array_keys($this);
            $last   = end($keys);
            if ($includeHeaders) {
                $ret = implode("$fieldSeparator", $keys) . $lineSeparator;
            } else {
                $ret = '';
            }
            
            foreach ($this as $index => $value) {
                $ret .= "$enclosed$value$enclosed";
                $ret .= (($last != $index) ? $fieldSeparator : $lineSeparator);
            }

            return $ret;
        }

        public function toYaml() {

        }

        public function toJson() {
            return json_encode($this->toArray());
        }
        
    }