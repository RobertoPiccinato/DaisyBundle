<?php

namespace Casagrande\DaisyBundle\Entity\Repository\Schema;

use Casagrande\DaisyBundle\Entity\DaisyUtil;
use Casagrande\DaisyBundle\Entity\Repository\ARepositoryItem;
use Casagrande\DaisyBundle\Entity\Repository\Repository;

class FieldType extends ARepositoryItem {
	
	protected $id;					    // integer
	protected $lastModified;		    // \DateTime
	protected $lastModifierId; 		    // integer
	protected $name;				    // string
	protected $valueType;               // string
	protected $multivalue;              // boolean
	protected $hierarchical;            // boolean
	protected $deprecated;              // boolean
	protected $aclAllowed;              // boolean
	protected $updateCount;			    // integer
	protected $size;       			    // integer
	protected $allowFreeEntry;          // boolean
	protected $loadSelectionListAsync;  // boolean
	protected $labels;                  // array
	protected $descriptions;            // array

		
	public function __construct() {

	    $this->labels = array();
	    $this->descriptions = array();
	}
	
	
	/**
	 * @param string(integer) $id
	 * @param Repository $repository
	 */
	public static function get($id, Repository $repository) {
    	
		$repository->sendGet('/repository/schema/fieldType/' . $id);
		
		return self::getFromDom($repository->getResponse());
	}
	
	/**
	 * @param string $name
	 * @param Repository $repository
	 */
	public static function getByName($name, Repository $repository) {
    	
		$repository->sendGet('/repository/schema/fieldTypeByName/' . $name);
		
		return self::getFromDom($repository->getResponse());
	}
	
	/**
	 * @param \DomDocument $dom
	 * @return FieldType
	 */
	public static function getFromDom($dom) {
		
		$fieldType = new FieldType();
		
		foreach($dom->documentElement->attributes as $attrName -> $attrNode) {
			
			switch($attrName) {
				
				case 'id':
					$fieldType->setId($attrNode->nodeValue);
					break;
				case 'lastModified':
					$fieldType->setLastModified($attrNode->nodeValue);
					break;
				case 'lastModifier':
					$fieldType->setLastModifierId($attrNode->nodeValue);
					break;
				case 'name':
					$fieldType->setName($attrNode->nodeValue);
					break;
				case 'valueType':
					$fieldType->setValueType($attrNode->nodeValue);
					break;
				case 'multivalue':
					$fieldType->setMultivalue($attrNode->nodeValue);
					break;
				case 'hierarchical':
					$fieldType->setHierarchical($attrNode->nodeValue);
					break;
				case 'deprecated':
					$fieldType->setDeprecated($attrNode->nodeValue);
					break;
				case 'aclAllowed':
					$fieldType->setAclAllowed($attrNode->nodeValue);
					break;
				case 'updateCount':
					$fieldType->setId($attrNode->nodeValue);
					break;
				case 'size':
					$fieldType->setSize($attrNode->nodeValue);
					break;
				case 'allowFreeEntry':
					$fieldType->setAllowFreeEntry($attrNode->nodeValue);
					break;
				case 'loadSelectionListAsync':
					$fieldType->setLoadSelectionListAsync($attrNode->nodeValue);
					break;
			}
		}
		
		foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'label') as $label) {
			
			$fieldType->labels[] = Label::getFromDom($label);
		}
		
		foreach($dom->getElementsByTagNameNS(DOCUMENT_NAMESPACE, 'description') as $description) {
			
			$fieldType->descriptions[] = Description::getFromDom($description);
		}
		
		return $fieldType;
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
	
	public function getValueType() {
		return $this->valueType;
	}
	public function setValueType($valueType) {
		$this->valueType = $valueType;
	}
	
	public function getHierarchical() {
		return $this->hierarchical;
	}
	public function setHierarchical($hierarchical) {
	    $this->hierarchical = DaisyUtil::parseBoolean($hierarchical);
	}
	
	public function getDeprecated() {
		return $this->deprecated;
	}
	public function setDeprecated($deprecated) {
	    $this->deprecated = DaisyUtil::parseBoolean($deprecated);
	}
	
	public function getAclAllowed() {
		return $this->aclAllowed;
	}
	public function setAclAllowed($aclAllowed) {
	    $this->aclAllowed = DaisyUtil::parseBoolean($aclAllowed);
	}
	
	public function getUpdateCount() {
		return $this->updateCount;
	}
	public function setUpdateCount($updateCount) {
	    $this->updateCount = $updateCount;
	}
	
	public function getSize() {
		return $this->size;
	}
	public function setSize($size) {
	    $this->size = $size;
	}
	
	public function getMultivalue() {
		return $this->multivalue;
	}
	public function setMultivalue($multivalue) {
	    $this->multivalue = DaisyUtil::parseBoolean($multivalue);
	}
	
	public function getAllowFreeEntry() {
		return $this->allowFreeEntry;
	}
	public function setAllowFreeEntry($allowFreeEntry) {
	    $this->allowFreeEntry = DaisyUtil::parseBoolean($allowFreeEntry);
	}
	
	public function getLoadSelectionListAsync() {
		return $this->loadSelectionListAsync;
	}
	public function setLoadSelectionListAsync($loadSelectionListAsync) {
	    $this->loadSelectionListAsync = DaisyUtil::parseBoolean($loadSelectionListAsync);
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