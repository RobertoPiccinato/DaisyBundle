<?php

namespace Casagrande\DaisyBundle\Entity;

class DaisyUtil {
	
	public static function parseBoolean($value) {
	    
	    switch(gettype($value)) {
	        case 'boolean':
	            
	            return $value;
	        case 'string':
	            
	            return ($multivalue == 'true') ? true : false;
	    }
	    
	    return false;
	}
	
	public static function parseInteger($value) {
	    
	    switch(gettype($value)) {
	        case 'integer':
	            return $value;
	        case 'string':
	            return intval($value);
	    }
	    
	    return false;
	}

	public static function parseDateTime($value) {
	    
	    switch(gettype($value)) {
	        case 'DateTime':
	            return $value;
	        case 'string':
	            return new \DateTime($value);
	    }
	    
	    return false;
	}

	/**
	 * @param DateTime $dateTime
	 * @return string
	 */
	public static function formatSOAPDateTime($dateTime) {
	   
	    return $dateTime->format('Y-m-dTh:m:i');
	}
}


?>
