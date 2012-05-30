<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Schema;

use Casagrande\DaisyBundle\Entity\Repository\ARepositoryItem;
use Casagrande\DaisyBundle\Entity\Repository\Repository;

class PartType extends ARepositoryItem {
	
	protected $name;				// string
	protected $mimeTypes;           // string
	protected $daisyHtml;           // boolean
	protected $linkExtractor;       // string
	protected $deprecated;          // boolean
	protected $updateCount;			// integer
	protected $id;					// integer
	protected $lastModified;		// \DateTime
	protected $lastModifierId; 		// integer
	protected $labels;              // array
	protected $descriptions;        // array
	
	/**
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, Repository $repository) {
    	
		$repository->sendGet('/repository/schema/partType/' . $id);
		
		return self::getFromXml($repository->getResponse());
	}
	
	/**
	 * @param \DomDocument $dom
	 * @return Branch
	 */
	public static function getFromDom($dom) {
		
		$partType = new PartType();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'name':
					$partType->setName($attrNode->nodeValue);
					break;
				case 'mimeTypes':
					$partType->setMimeTypes($attrNode->nodeValue);
					break;
				case 'daisyHtml':
					$partType->setDaisyHtml($attrNode->nodeValue);
					break;
				case 'linkExtractor':
					$partType->setLinkExtractor($attrNode->nodeValue);
					break;
				case 'deprecated':
					$partType->setDeprecated($attrNode->nodeValue);
					break;
				case 'updateCount':
					$partType->setId($attrNode->nodeValue);
					break;
				case 'id':
					$partType->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$partType->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$partType->setLastModifierId($attrNode->nodeValue);
					break;
			}
		}
		
		foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'label') as $label) {
			
			$partType->addLabel(Label::getFromDom($label));
		}
		
		foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'description') as $description) {
			
			$partType->addDescription(Label::getFromDom($description));
		}
		
		return $partType;
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
}