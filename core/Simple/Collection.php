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

	class Simple_Collection extends Ancestor implements IteratorAggregate {
        private $_data      = array();
        
        public function __construct() {
            ;
        }
        
        public function __destruct() {
			foreach ($this as $index => $value){
				unset($this->$index);
			}
		}
        
        // -- Collection
        
        public function add($object, $index = null) {
			if ($index) {
                $this->_data[$index] = $object;
            } else {
                $this->_data[] = $object;
            }
            
	        return $this;
		}
        
        public function getIterator() {
			return new ArrayIterator($this->_data);
		}
        
        public function getFirstItem() {
	        if (count($this->_data)) {
	            reset($this->_data);
	            return current($this->_data);
	        }
            
            return null;
	    }
	    
		public function getLastItem() {
	
	        if (count($this->_data)) {
	            return end($this->_data);
	        }
	
	        return null;
	    }
	    
	    public function clear() {
	    	$this->_data = array();
	    	return $this;
	    }
        
        public function getAllItemsToArray() {
            return $this->_data;
        }
        
        // -- Countable
        
	    public function count() {
	    	return count($this->_data);
	    }
	    
        public function sum($field) {
            $total = 0;
            
            foreach ($this as $record) {
                $total += $record->getData($field);
            }
            
            return $total;
        }
        
        public function max($field) {
            $max = null;
            
            foreach ($this as $record) {
                if ($max == null || $record->getData($field) > $max) {
                    $max = $record->getData($field);
                }
            }
            
            return $max;
        }
        
        public function min($field) {
            $min = null;
            
            foreach ($this as $record) {
                if ($min == null || $record->getData($field) < $min) {
                    $min = $record->getData($field);
                }
            }
            
            return $min;
        }
        
        public function avg($field) {
            $total = 0;
            
            foreach ($this as $record) {
                $total += $record->getData($field);
            }
            
            return ($total / $this->count());
        }
        
    }