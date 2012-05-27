<?php

namespace Casagrande\DaisyBundle\Entity\Repository;

class Language extends ARepositoryItem {
	
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
    	
		$repository->sendGet('/repository/language/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param \DomDocument $dom
	 * @return Language
	 */
	public static function getFromDom($dom) {
	
		$language = new Language();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'name':
					$language->setName($attrNode->nodeValue);
					break;
				case 'id':
					$language->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$language->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$language->setLastModifierId($attrNode->nodeValue);
					break;
				case 'updateCount':
					$language->setId($attrNode->nodeValue);
					break;
			}
		}
		
		return $language;
	}
	
	/**
	 * Restituisce tutte le lingue
	 * @param Respository $repository
	 * @return array
	 */
	public static function getLanguages(Repository $repository) {
		 		
		$repository->sendGet('/repository/language');
		
		$languages = array();
		
		if($dom = \DOMDocument::loadXML($repository->getResponse())) {

			foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'language') as $language) {
				
				$language[] = self::getFromDom($language);
			}
		}
		
		return $languages;
	}

	public static function getLanguageByName($name, $repository) {
    	
		$repository->sendGet('/repository/languageByName/' . $name);
		
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