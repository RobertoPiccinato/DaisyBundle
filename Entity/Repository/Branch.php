<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

class Branch extends ARepositoryItem {
	
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
    	
		$repository->sendGet('/repository/branch/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \DomDocument $dom
	 * @return Branch
	 */
	public static function getFromDom($dom) {
		
		$branch = null;

		$branch = new Branch();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'name':
					$branch->setName($attrNode->nodeValue);
					break;
				case 'id':
					$branch->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$branch->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$branch->setLastModifierId($attrNode->nodeValue);
					break;
				case 'updateCount':
					$branch->setId($attrNode->nodeValue);
					break;
			}
		}
		
		return $branch;
	}
	
	/**
	 * Restituisce tutti i ruoli
	 * @param Respository $repository
	 * @return array
	 */
	public static function getBranches(Repository $repository) {
		 		
		$repository->sendGet('/repository/branch');
		
		$branches = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'branch') as $branch) {
				
				$branches[] = self::getFromDom($branch);
			}
		}
		
		return $branches;
	}

	public static function getBranchByName($name, $repository) {
    	
		$repository->sendGet('/repository/branchByName/' . $name);
		
		return self::getFromXml($repository->getResponse());
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
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