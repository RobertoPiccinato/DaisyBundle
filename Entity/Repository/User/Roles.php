<?php

namespace Casagrande\DaisyBundle\Entity\Repository\User;

use Casagrande\DaisyBundle\Entity\DaisyUtil;
use Casagrande\DaisyBundle\Entity\Repository\Repository;
use Casagrande\DaisyBundle\Entity\Repository\RepositoryItem;

class Role implements RepositoryItem {
	
	protected $roles;			// array
	
	public static function getFromXml($xml) {
	    
	    $reader = new \XMLReader();
	    $reader->xml($xml);
	    $reader->read();
	    
	    $roles = self::getFromXMLReader($reader);
	    
	    return $roles;
	}
	
	/**
	 * @param \XMLReader $reader
	 * @return Roles
	 */
	public static function getFromXMLReader(\XMLReader $reader) {
		
	    $roles = false;
	    
	    if($reader->localName == 'roles') {
	        
		    $roles = new Roles();
		    
		    $reader->read();
		    
		    $role = null;
		    
		    while($reader->localName == 'role') {
		        
		        $role = Role::getFromReader($reader);
		        $this->roles[] = $role;
		        
		        $reader->read();
		    }
	    }
	    
		return $roles;
	}
	
	/**
	 * @param XMLWriter $writer
	 * @return string
	 */
	public function getXml(&$writer = null) {

	    if(is_null($writer)) {
	        
	        $writer = new \XMLWriter();
	        $writer->openMemory();
	        $writer->startDocument('1.0');
	    }
	    
	    $writer->startElementNS('ns', 'roles', DaisyConfig::DOCUMENT_NAMESPACE);
        
	    foreach($this->roles as $role) {
            
	        Role:getXml($writer);
        }
        
	    $writer->endElement();
	    
	    return $writer->outputMemory(false);
	}
	
	public function __construct() {
	    
	    $this->roles = array();
	}
	
	/**
	 * @param Role $role
	 */
	public function add(Role $role) {
	    
	    if(!in_array($role, $this->roles)) {
	        
	        $this->roles[] = $role;
	    }
	}
	
	/**
	 * @param Role $role
	 */
	public function remove(Role $role) {
	    
	    for($i = 0; $i < count($this->roles); $i++) {
	        
	        if($this->roles[$i] === $role) {
	            
	            unset($this->roles[$i]);
	            $this->roles = array_values($this->roles);
	        }
	    }
	}
}