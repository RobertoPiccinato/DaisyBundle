<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

class Role extends ARepositoryItem {
	
	private $description;			// string
	private $name;					// string
	private $id;					// integer
	private $lastModified;			// \DateTime
	private $lastModifierId; 		// integer
	private $updateCount;			// integer
	
	/**
	 * 
	 * Enter description here ...
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, $repository) {
    	
		$repository->sendGet('/repository/role/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \DomDocument $dom
	 * @return Role
	 */
	public static function getFromDom($dom) {
		
		$role = null;

		$role = new Role();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'description':
					$role->setDescription($attrNode->nodeValue);
					break;
				case 'name':
					$role->setName($attrNode->nodeValue);
					break;
				case 'id':
					$role->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$role->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$role->setLastModifierId($attrNode->nodeValue);
					break;
				case 'updateCount':
					$role->setId($attrNode->nodeValue);
					break;
			}
		}
		
		return $role;
	}
	
	/**
	 * Restituisce tutti i ruoli
	 * @param Respository $repository
	 * @return array
	 */
	public static function getRoles($repository) {
		 		
		$repository->sendGet('/repository/role');
		
		$roles = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'role') as $role) {
				
				$roles[] = self::getFromDom($role);
			}
		}
		
		return $roles;
	}

	public static function getRoleByName($name, $repository) {
    	
		$repository->sendGet('/repository/roleByName/' . $name);
		
		return self::getFromXml($repository->getResponse());
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
	}

	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getLastModified() {
		return $this->lastModified;
	}
	public function setLastModified($lastModified) {
		$this->lastModified = $lastModified;
	}
	
	public function getLastModifierId() {
		return $this->lastModifierId;
	}
	public function getLastModifier(Repository $repository) {
		return User::get($this->getLastModifierId, $repository);
	}
	public function setLastModifierId($lastModifierId) {
		$this->lastModifierId = $lastModifierId;
	}
	
	public function getUpdateCount() {
		return $this->updateCount;
	}
	public function setUpdateCount($updateCount) {
		$this->updateCount = $updateCount;
	}
}