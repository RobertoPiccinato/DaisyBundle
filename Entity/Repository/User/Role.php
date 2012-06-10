<?php

namespace Casagrande\DaisyBundle\Entity\Repository\User;

use Casagrande\DaisyBundle\Entity\DaisyUtil;
use Casagrande\DaisyBundle\Entity\DaisyConfig;
use Casagrande\DaisyBundle\Entity\Repository\Repository;
use Casagrande\DaisyBundle\Entity\Repository\RepositoryItem;

class Role implements RepositoryItem {
	
	protected $description;			// string
	protected $name;				// string
	protected $id;					// integer
	protected $lastModified;		// \DateTime
	protected $lastModifierId; 		// integer
	protected $updateCount;			// integer
	
	/**
	 * @param integer $id
	 * @param Repository $repository
	 */
	public static function get($id, Repository $repository) {
    	
		$repository->sendGet('/repository/role/' . $id);

		$response = $repository->getResponse();
		
		return self::getFromXml($response);
	}
	
	public static function getFromXml($xml) {
	    
	    $reader = new \XMLReader();
	    $reader->xml($xml);
	    $reader->read();
	    
	    $role = self::getFromXMLReader($reader);
	    
	    return $role;
	}
	
	/**
	 * @param \XMLReader $reader
	 * @return Role
	 */
	public static function getFromXMLReader(\XMLReader &$reader) {
		
	    $role = false;
	    
	    if($reader->localName == 'role') {
	        
		    $role = new Role();
	    
		    $role->setDescription($reader->getAttribute('description'));
		    $role->setName($reader->getAttribute('name'));
		    $role->updateCount = DaisyUtil::parseInteger($reader->getAttribute('updateCount'));
		    $role->id = DaisyUtil::parseInteger($reader->getAttribute('id'));
		    $role->lastModified = DaisyUtil::parseDateTime($reader->getAttribute('lastModified'));
		    $role->lastModifierId = DaisyUtil::parseInteger($reader->getAttribute('lastModifier'));
	    }
	    
		return $role;
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
	    
	    $writer->startElementNS('ns', 'role', DaisyConfig::DOCUMENT_NAMESPACE);
	    $writer->writeAttribute('description', $this->getDescription());
	    $writer->writeAttribute('name', $this->getName());
	    $writer->writeAttribute('updateCount', $this->getUpdateCount());
	    $writer->writeAttribute('id', $this->getId());
	    $writer->writeAttribute('lastModified', DaisyUtil::formatSOAPDateTime($this->getLastModified()));
	    $writer->writeAttribute('lastModifier', $this->getLastModifierId());
	    $writer->endElement();
	    
	    return $writer->outputMemory(false);
	}
	
	public static function getByName($name, Repository $repository) {
    	
		$repository->sendGet('/repository/roleByName/' . $name);
		
		$response = $repository->getResponse();
		
		return self::getFromXml($response);
	}
	
	/**
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	/**
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * @return DateTime
	 */
	public function getLastModified() {
		return $this->lastModified;
	}
	
	/**
	 * @return integer
	 */
	public function getLastModifierId() {
		return $this->lastModifierId;
	}
	/**
	 * @param Repository $repository
	 * @return User
	 */
	public function getLastModifier(Repository $repository) {
		return User::get($this->getLastModifierId(), $repository);
	}
	
	/**
	 * @return integer
	 */
	public function getUpdateCount() {
		return $this->updateCount;
	}
}