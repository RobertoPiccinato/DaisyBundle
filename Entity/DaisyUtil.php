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
}


?>
