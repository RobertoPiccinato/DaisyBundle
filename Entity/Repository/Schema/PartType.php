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

		
	public function __construct() {

	    $this->labels = array();
	    $this->descriptions = array();
	}
	
	
	/**
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, Repository $repository) {
    	
		$repository->sendGet('/repository/schema/partType/' . $id);
		
		return self::getFromDom($repository->getResponse());
	}
	
	/**
	 * @param string $name
	 * @param Repository $repository
	 */
	public static function getByName($name, Repository $repository) {
    	
		$repository->sendGet('/repository/schema/partTypeByName/' . $name);
		
		return self::getFromDom($repository->getResponse());
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
			
			$partType->labels[] = Label::getFromDom($label);
		}
		
		foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'description') as $description) {
			
			$partType->descriptions[] = Description::getFromDom($description);
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
	
	public function getDeprecated() {
		return $this->deprecated;
	}
	public function setDeprecated($deprecated) {
	    $this->deprecated = DaisyUtil::parseBoolean($deprecated);
	}
	
	public function getLinkExtractor() {
		return $this->linkExtractor;
	}
	public function setLinkExtractor($linkExtractor) {
	    $this->linkExtractor = $linkExtractor;
	}
	
	public function getUpdateCount() {
		return $this->updateCount;
	}
	public function setUpdateCount($updateCount) {
	    $this->updateCount = $updateCount;
	}
	
	public function addLabel(Label $label) {
	    foreach($this->labels as $l) {
	        if($l->getLocale() == $label->getLocale()) {
	            $l->setText($label->getText());
	            return $l;
	        }
	    }
	    
	    $this->labels[] = $label;
	    
	    return $this->labels;
	}
	public function removeLabel(Label $label) {
	    foreach($this->labels as $l) {
	        if($l->getLocale() == $label->getLocale()) {
	            unset($l);
	        }
	    }
	    
	    return $this->labels;
	}
	public function removeLabelByLocale($locale) {
	    foreach($this->labels as $l) {
	        if($l->getLocale() == $locale) {
	            unset($l);
	        }
	    }
	    
	    return $this->labels;
	}
	
	public function addDescription(Description $description) {
	    foreach($this->descriptions as $d) {
	        if($d->getLocale() == $description->getLocale()) {
	            $d->setText($description->getText());
	            return $d;
	        }
	    }
	    
	    $this->descriptions[] = $description;
	    
	    return $this->descriptions;
	}
	public function removeDescription(Description $description) {
	    foreach($this->descriptions as $d) {
	        if($d->getLocale() == $description->getLocale()) {
	            unset($d);
	        }
	    }
	    
	    return $this->descriptions;
	}
	public function removeDescriptionByLocale($locale) {
	    foreach($this->descriptions as $d) {
	        if($d->getLocale() == $description) {
	            unset($d);
	        }
	    }
	    
	    return $this->descriptions;
	}
}