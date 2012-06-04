<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

class Collection extends ARepositoryItem {
	
	private $name;					// string
	private $id;					// integer
	private $lastModified;			// \DateTime
	private $lastModifierId; 		// integer
	private $updateCount;			// integer
	
	/**
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, $repository) {
    	
		$repository->sendGet('/repository/collection/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \DomDocument $dom
	 * @return Collection
	 */
	public static function getFromDom($dom) {
		
		$collection = new Collection();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'name':
					$collection->setName($attrNode->nodeValue);
					break;
				case 'id':
					$collection->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$collection->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$collection->setLastModifierId($attrNode->nodeValue);
					break;
				case 'updateCount':
					$collection->setId($attrNode->nodeValue);
					break;
			}
		}
		
		return $collection;
	}
	
	/**
	 * Restituisce tutti i ruoli
	 * @param Respository $repository
	 * @return array
	 */
	public static function getCollections(Repository $repository) {
		 		
		$repository->sendGet('/repository/collection');
		
		$collection = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'collection') as $collection) {
				
				$collections[] = self::getFromDom($collection);
			}
		}
		
		return $collections;
	}

	public static function getByName($name, $repository) {
    	
		$repository->sendGet('/repository/collectionByName/' . $name);
		
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